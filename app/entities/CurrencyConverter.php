<?php


namespace entities;


use controllers\AbstractController;

class CurrencyConverter
{
    public static function entityToArray(Currency $entity)
    {
        return [
            'name' => $entity->getName(),
            'code' => $entity->getCode(),
            'middleRate' => $entity->getMiddleRate(),
            'date' => $entity->getDate()
        ];
    }

    public static function arrayToEntity($array): Currency
    {
        return new Currency(
            $array['name'],
            $array['code'],
            $array['middleRate'],
            $array['date']
        );
    }

    public static function jsonToEntities($json): array
    {
        $currencies = json_decode($json);

        $currenciesArr = array();
        foreach ($currencies as $currency)
        {
            $date = $currency->effectiveDate;
            foreach ($currency->rates as $rate)
            {
                array_push($currenciesArr, new Currency(
                (String)$rate->currency,
                (String)$rate->code,
                (float)$rate->mid,
                $date));
            }
        }

        return $currenciesArr;
    }
}