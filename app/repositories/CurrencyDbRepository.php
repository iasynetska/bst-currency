<?php

namespace repositories;
use entities\Currency;

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

    public function getCurrencyFromTo($from, $to): array
    {
        // TODO: add masks
        $sql = "SELECT * FROM currency WHERE date >= :from AND date <= :to";

        $params = array('from'=>$from, 'to'=>$to);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
