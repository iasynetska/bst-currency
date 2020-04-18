<?php


namespace services;


interface CurrencyServiceInterface
{
    public function getCurrencyByDateAndCurrencyId(String $from, String $to, String $currencyId): array;
    public function populateDbWithCurrencies();
}