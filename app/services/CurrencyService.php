<?php

namespace services;

use apiclients\CbrCurrencyApiClient;
use core\DbConnection;
use Exception;
use repositories\CurrencyDbRepository;

class CurrencyService implements CurrencyServiceInterface
{
    private $currencyRepository;
    private $currencyApiClient;


    public function __construct(CurrencyDbRepository $currencyRepository, CbrCurrencyApiClient $currencyApiClient)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyApiClient = $currencyApiClient;
    }


    public function getCurrencyByDateAndCurrencyId(String $from, String $to, String $currencyCode): array
    {
        return $this->currencyRepository->getCurrencyByDateAndCurrencyCode($from, $to, $currencyCode);
    }

    public function getMinAndMaxDate()
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