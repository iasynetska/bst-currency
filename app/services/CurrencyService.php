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


    public function getCurrencyByDateAndValuteId(String $from, String $to, String $valuteId): array
    {
        return $this->currencyRepository->getCurrencyByDateAndValuteId($from, $to, $valuteId);
    }
}