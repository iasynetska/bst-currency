<?php

namespace services;

use apiclients\CbrCurrencyApiClient;
use core\DbConnection;
use Exception;
use repositories\CurrencyDbRepository;

class CurrencyService implements CurrencyServiceInterface
{
    private $apiDateFormat = 'd/m/Y';
    private $apiDaysToFillDb = 30;

    private $currencyRepository;
    private $currencyApiClient;


    public function __construct(CurrencyDbRepository $currencyRepository, CbrCurrencyApiClient $currencyApiClient)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyApiClient = $currencyApiClient;
    }


    public function getCurrencyByDateAndCurrencyId(String $from, String $to, String $currencyId): array
    {
        return $this->currencyRepository->getCurrencyByDateAndCurrencyId($from, $to, $currencyId);
    }


    public function populateDbWithCurrencies()
    {
        $date = date($this->apiDateFormat);

        try{
            DbConnection::getPDO()->beginTransaction();
            $this->currencyRepository->deleteAllCurrencies();

            for ($i = 0; $i <=$this->apiDaysToFillDb; $i++)
            {
                $currencies = $this->currencyApiClient->getCurrenciesByDate($date);
                foreach ($currencies as $currency)
                {
                    $this->currencyRepository->addCurrency($currency);
                }

                $date = date($this->apiDateFormat, strtotime($currencies[0]->getDate() . ' -1 day'));
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