<?php

namespace services;

use apiclients\NbpCurrencyApiClient;
use core\DbConnection;
use Exception;
use repositories\CurrencyDbRepository;

class CurrencyService implements CurrencyServiceInterface
{
    private $currencyRepository;
    private $currencyApiClient;


    public function __construct(CurrencyDbRepository $currencyRepository, NbpCurrencyApiClient $currencyApiClient)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyApiClient = $currencyApiClient;
    }


    public function getCurrencyByDateAndCurrencyCode(String $from, String $to, String $currencyCode): array
    {
        return $this->currencyRepository->getCurrencyByDateAndCurrencyCode($from, $to, $currencyCode);
    }

    public function getCurrenciesByDateRange(String $from, String $to): array
    {
        return $this->currencyRepository->getCurrenciesByDateRange($from, $to);
    }

    public function getCurrenciesByDate(String $date)
    {
        return $this->currencyRepository->getCurrenciesByDate($date);
    }

    public function getMinAndMaxDate(): array
    {
        return $this->currencyRepository->getMinAndMaxDate();
    }

    public function populateDbWithCurrencies()
    {
        try{
            DbConnection::getPDO()->beginTransaction();
            $this->currencyRepository->deleteAllCurrencies();
            $currencies = $this->currencyApiClient->getCurrenciesByDate();
            foreach ($currencies as $currency)
            {
                $this->currencyRepository->addCurrency($currency);
            }
            DbConnection::getPDO()->commit();
        }
        catch (Exception $e)
        {
            DbConnection::getPDO()->rollBack();
            throw $e;
        }
    }
}