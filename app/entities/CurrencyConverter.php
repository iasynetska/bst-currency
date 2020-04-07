<?php


namespace entities;


class CurrencyConverter
{
    public static function entityToArray(Currency $entity)
    {
        return [
            'valuteID' => $entity->getValuteID(),
            'numCode' => $entity->getNumCode(),
            'сharCode' => $entity->getСharCode(),
            'name' => $entity->getName(),
            'value' => $entity->getValue(),
            'date' => $entity->getDate()
        ];
    }

    public static function arrayToEntity($array): Currency
    {
        return new Currency(
            $array['valuteID'],
            $array['numCode'],
            $array['сharCode'],
            $array['name'],
            $array['value'],
            $array['date']
        );
    }
}