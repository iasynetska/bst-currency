<?php


namespace core;


class RequestValidator
{
    private $langManager;

    public function __construct(LangManager $langManager)
    {
        $this->langManager = $langManager;
    }

    public function validateDataForCurrencyReport($currencySelected, $from, $to)
    {
        $validationResult = array();
        $fromCorrect = true;
        $toCorrect = true;

        if($this->isEmpty($currencySelected))
        {
            array_push($validationResult, $this->langManager->getLangParam("currencySelectedErrorNotSelected"));
        }
        elseif(!$this->isCurrencyCodeCorrect($currencySelected))
        {
            array_push($validationResult, $this->langManager->getLangParam("currencyCodeErrorInvalid"));
        }

        if($this->isEmpty($from))
        {
            array_push($validationResult, $this->langManager->getLangParam("fromErrorNotSelected"));
            $fromCorrect = false;
        }
        elseif(!$this->isDateCorrect($from))
        {
            array_push($validationResult, $this->langManager->getLangParam("fromErrorInvalidFormat"));
            $fromCorrect = false;
        }

        if($this->isEmpty($to))
        {
            array_push($validationResult, $this->langManager->getLangParam(("toErrorNotSelected")));
            $toCorrect = false;
        }
        elseif(!$this->isDateCorrect($to))
        {
            array_push($validationResult, $this->langManager->getLangParam("toErrorInvalidFormat"));
            $toCorrect = false;
        }

        if($fromCorrect && $toCorrect)
        {
            if(!$this->isToLargerFrom($from, $to))
            {
                array_push($validationResult, $this->langManager->getLangParam("periodErrorFromLargerTo"));
            }
        }

        return $validationResult;
    }


    private function isEmpty($value): bool
    {
        return $value === null || $value === "";
    }

    private function isCurrencyCodeCorrect(String $currencySelected): bool
    {
        if (preg_match("/^[A-Z]{3}$/", $currencySelected)) {
            return true;
        } else {
            return false;
        }
    }

    private function isDateCorrect(String $date): bool
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return true;
        } else {
            return false;
        }
    }

    private function isToLargerFrom(String $from, String $to): bool
    {
        return strtotime($to) > strtotime($from);
    }
}