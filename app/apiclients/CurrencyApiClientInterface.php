<?php


namespace apiclients;


interface CurrencyApiClientInterface
{
    public function getCurrenciesByDate(): array;
}