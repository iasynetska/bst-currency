<?php

namespace currencies;

class CurrencyUtils
{
    public static function getAllCurrencyIds(): array
    {
        $currencies = simplexml_load_file('app/currencies/currencies.xml');

        $currenciesArr = array();
        foreach ($currencies as $currency)
        {
            array_push($currenciesArr, ['id' => (string)$currency->ID, 'charCode' => (string)$currency->CharCode]);
        }

        return $currenciesArr;
    }
}