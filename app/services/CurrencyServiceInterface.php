<?php


namespace services;


interface CurrencyServiceInterface
{
    public function getCurrencyByDateAndValuteId(String $from, String $to, String $valuteId): array;
    public function populateDbWithCurrencies();

}