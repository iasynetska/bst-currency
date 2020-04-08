<?php


namespace repositories;


use entities\Currency;

interface CurrencyRepositoryInterface
{
    public function addCurrency(Currency $currency): void;
    public function getCurrencyByDateAndValuteId(String $from, String $to, String $valuteId): array;
    public function deleteCurrencyByDate(String $date): void;
}