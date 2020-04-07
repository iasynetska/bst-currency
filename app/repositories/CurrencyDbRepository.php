<?php

namespace repositories;
use entities\Currency;
use entities\CurrencyConverter;

class CurrencyDbRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function addCurrency(Currency $currency): void
    {
        // TODO: add masks
        $sql = "INSERT INTO currency (valuteID, numCode, сharCode, name, value, date) VALUES (:valuteID, :numCode, :сharCode, :name, :value, :date)";

        $params = array(
            'valuteID'=>$currency->getValuteID(),
            'numCode'=>$currency->getNumCode(),
            'сharCode'=>$currency->getСharCode(),
            'name'=>$currency->getName(),
            'value'=>$currency->getValue(),
            'date'=>$currency->getDate()
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function getCurrencyByDateAndValuteId(String $from, String $to, String $valuteId): array
    {
        // TODO: add masks
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
}
