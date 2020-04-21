<?php


namespace services;


interface CurrencyServiceInterface
{
    public function getCurrencyByDateAndCurrencyCode(String $from, String $to, String $currencyCode): array;
    public function populateDbWithCurrencies();
}