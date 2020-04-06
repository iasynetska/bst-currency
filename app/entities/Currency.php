<?php


namespace entities;

class Currency
{
    private $valuteID;
    private $numCode;
    private $сharCode;
    private $name;
    private $value;
    private $date;


    public function __construct(String $valuteID, int $numCode, String $сharCode, String $name, float $value, $date)
    {
        $this->valuteID = $valuteID;
        $this->numCode = $numCode;
        $this->сharCode = $сharCode;
        $this->name = $name;
        $this->value = $value;
        $this->date = $date;
    }

    public function getValuteID(): String
    {
        return $this->valuteID;
    }

    public function getNumCode(): int
    {
        return $this->numCode;
    }

    public function getСharCode(): String
    {
        return $this->сharCode;
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