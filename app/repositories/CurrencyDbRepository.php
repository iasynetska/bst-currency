<?php

namespace repositories;
use entities\Currency;
use entities\CurrencyConverter;
use PDO;

class CurrencyDbRepository implements CurrencyRepositoryInterface
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addCurrency(Currency $currency): void
    {
        $sql = "INSERT INTO currency (currencyID, numCode, currencyCode, name, value, date) VALUES (:currencyID, :numCode, :currencyCode, :name, :value, :date)";

        $currencyID = $currency->getCurrencyID();
        $numCode = $currency->getNumCode();
        $currencyCode = $currency->getCurrencyCode();
        $name = $currency->getName();
        $value = $currency->getValue();
        $date = $currency->getDate();

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':currencyID', $currencyID, PDO::PARAM_STR);
        $stmt->bindParam(':numCode', $numCode, PDO::PARAM_INT);
        $stmt->bindParam(':currencyCode', $currencyCode, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':date', $date);


        $stmt->execute();
    }

    public function getCurrencyByDateAndCurrencyId(String $from, String $to, String $currencyID): array
    {
        $sql = "SELECT * FROM currency WHERE date >= :from AND date <= :to AND currencyID = :currencyID";

        $params = array('from'=>$from, 'to'=>$to, 'currencyID'=>$currencyID);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll();

        $arr_currencies = [];
        foreach ($result as $currency)
        {
            array_push($arr_currencies, CurrencyConverter::arrayToEntity($currency));
        }

        return $arr_currencies;
    }

    public function deleteAllCurrencies(): void
    {
        $sql = "DELETE FROM currency";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function getMinAndMaxDate(): array
    {
        $sql = "SELECT min(date) AS min_date, max(date) AS max_date FROM currency";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        return array("minDate" => $result["min_date"], "maxDate" => $result["max_date"]);
    }
}
