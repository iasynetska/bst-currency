<?php

namespace services;

use apiclients\CbrApiClient;
use core\DbConnection;
use Exception;
use repositories\CurrencyDbRepository;

class CurrencyService
{
    private $apiDateFormat = 'd/m/Y';
    private $apiDaysToFillDb = 30;

    private $currencyRepository;
    private $currencyApiClient;


    public function __construct(CurrencyDbRepository $currencyRepository, CbrApiClient $currencyApiClient)
    {
        $this->currencyRepository = $currencyRepository;
        $this->currencyApiClient = $currencyApiClient;
    }


    public function getCurrencyByDateAndValuteId(String $from, String $to, String $valuteId): array
    {
        return $this->currencyRepository->getCurrencyByDateAndValuteId($from, $to, $valuteId);
    }


    public function populateDbWithCurrencies()
    {
        $date = date($this->apiDateFormat);

        for ($i = 0; $i <=$this->apiDaysToFillDb; $i++)
        {
            try{
                DbConnection::getPDO()->beginTransaction();
                $currencies = $this->currencyApiClient->getCurrenciesByDate($date);
                $this->currencyRepository->deleteCurrencyByDate($currencies[0]->getDate());

                foreach ($currencies as $currency)
                {
                    $this->currencyRepository->addCurrency($currency);
                }
                DbConnection::getPDO()->commit();

                $date = date($this->apiDateFormat, strtotime($currencies[0]->getDate() . ' -1 day'));
            }
            catch (Exception $e)
            {
                DbConnection::getPDO()->rollBack();
                throw $e;
            }
        }
    }
}