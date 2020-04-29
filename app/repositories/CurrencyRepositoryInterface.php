<?php


namespace repositories;


use entities\Currency;

interface CurrencyRepositoryInterface
{
    public function addCurrency(Currency $currency): void;
    public function getCurrencyByDateAndCurrencyCode(String $from, String $to, String $currencyID): array;
    public function getCurrenciesByDateRange(String $from, String $to): array;
    public function getCurrenciesByDate(String $date): array;
    public function deleteAllCurrencies(): void;
    public function getMinAndMaxDate(): array;
}