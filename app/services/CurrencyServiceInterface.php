<?php


namespace services;


interface CurrencyServiceInterface
{
    public function getCurrencyByDateAndCurrencyId(String $from, String $to, String $currencyCode): array;
    public function populateDbWithCurrencies();
}