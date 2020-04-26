<?php


namespace services;


interface CurrencyServiceInterface
{
    public function getCurrencyByDateAndCurrencyCode(String $from, String $to, String $currencyCode): array;
    public function getCurrenciesByDateRange(String $from, String $to): array;
    public function getCurrenciesByDate(String $date);
    public function getMinAndMaxDate(): array;
    public function populateDbWithCurrencies();
}