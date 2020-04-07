<?php

namespace services;

use repositories\CurrencyDbRepository;

class CurrencyService
{
    private $currencyRepository;


    public function __construct(CurrencyDbRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }


    public function getCurrencyFromTo($from, $to): array
    {
        return $this->currencyRepository->getCurrencyFromTo($from, $to);
    }
}