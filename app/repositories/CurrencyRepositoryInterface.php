<?php


namespace repositories;


use entities\Currency;

interface CurrencyRepositoryInterface
{
    public function addCurrency(Currency $currency): void;
    public function getCurrencyByDateAndCurrencyCode(String $from, String $to, String $currencyID): array;
    public function deleteAllCurrencies(): void;
}