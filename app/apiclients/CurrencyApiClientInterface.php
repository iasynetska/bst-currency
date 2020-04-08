<?php


namespace apiclients;


interface CurrencyApiClientInterface
{
    public function getCurrenciesByDate(String $date): array;
}