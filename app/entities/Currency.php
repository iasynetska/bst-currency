<?php


namespace entities;

class Currency
{
    private $currencyID;
    private $numCode;
    private $currencyCode;
    private $name;
    private $value;
    private $date;


    public function __construct(String $currencyID, int $numCode, String $currencyCode, String $name, float $value, $date)
    {
        $this->currencyID = $currencyID;
        $this->numCode = $numCode;
        $this->currencyCode = $currencyCode;
        $this->name = $name;
        $this->value = $value;
        $this->date = $date;
    }

    public function getCurrencyID(): String
    {
        return $this->currencyID;
    }

    public function getNumCode(): int
    {
        return $this->numCode;
    }

    public function getCurrencyCode(): String
    {
        return $this->currencyCode;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getDate()
    {
        return $this->date;
    }

}