<?php


namespace entities;

class Currency
{
    private $name;
    private $code;
    private $middleRate;
    private $date;


    public function __construct(String $name, String $code, float $middleRate, $date)
    {
        $this->name = $name;
        $this->code = $code;
        $this->middleRate = $middleRate;
        $this->date = $date;
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function getCode(): String
    {
        return $this->code;
    }

    public function getMiddleRate(): String
    {
        return $this->middleRate;
    }

    public function getDate()
    {
        return $this->date;
    }

}