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
        $sql = "INSERT INTO currency (valuteID, numCode, сharCode, name, value, date) VALUES (:valuteID, :numCode, :charCode, :name, :value, :date)";

        $valuteID = $currency->getValuteID();
        $numCode = $currency->getNumCode();
        $charCode = $currency->getСharCode();
        $name = $currency->getName();
        $value = $currency->getValue();
        $date = $currency->getDate();

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':valuteID', $valuteID, PDO::PARAM_STR);
        $stmt->bindParam(':numCode', $numCode, PDO::PARAM_INT);
        $stmt->bindParam(':charCode', $charCode, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':date', $date);


        $stmt->execute();
    }

    public function getCurrencyByDateAndValuteId(String $from, String $to, String $valuteId): array
    {
        $sql = "SELECT * FROM currency WHERE date >= :from AND date <= :to AND valuteID = :valuteID";

        $params = array('from'=>$from, 'to'=>$to, 'valuteID'=>$valuteId);

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

    public function deleteCurrencyByDate(String $date): void
    {
        $sql = "DELETE FROM currency WHERE date=:date";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':date', $date);
        $stmt->execute();
    }
}
