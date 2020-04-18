<?php


namespace entities;


use controllers\AbstractController;

class CurrencyConverter
{
    public static function entityToArray(Currency $entity)
    {
        return [
            'currencyID' => $entity->getCurrencyID(),
            'numCode' => $entity->getNumCode(),
            'currencyCode' => $entity->getCurrencyCode(),
            'name' => $entity->getName(),
            'value' => $entity->getValue(),
            'date' => $entity->getDate()
        ];
    }

    public static function arrayToEntity($array): Currency
    {
        return new Currency(
            $array['currencyID'],
            $array['numCode'],
            $array['currencyCode'],
            $array['name'],
            $array['value'],
            $array['date']
        );
    }

    public static function xmlToEntities($xml): array
    {
        $currencies = simplexml_load_string($xml);

        $date = date(AbstractController::DATE_FORMAT, strtotime((String)$currencies->attributes()->Date));

        $currenciesArr = array();
        foreach ($currencies->children() as $currency)
        {
            array_push($currenciesArr, new Currency(
                (String)$currency->attributes()->ID,
                (int)$currency->NumCode,
                (String)$currency->CharCode,
                (String)$currency->Name,
                (float)str_replace(',','.',(String)$currency->Value),
                $date
            ));
        }

        return $currenciesArr;
    }
}