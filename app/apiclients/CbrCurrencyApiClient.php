<?php

namespace apiclients;

use entities\CurrencyConverter;
use Exception;

class CbrCurrencyApiClient implements CurrencyApiClientInterface
{
    private $errors = [
        301 => 'Moved permanently',
        400 => 'Bad request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not found',
        500 => 'Internal server error',
        502 => 'Bad gateway',
        503 => 'Service unavailable',
    ];

    /**
     * @param String $date format d/m/Y
     * @return array of Currency
     * @throws Exception
     */
    public function getCurrenciesByDate(String $date): array
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'http://www.cbr.ru/scripts/XML_daily_eng.asp?date_req=' . $date);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->checkResponseCode((int)$code);

        return CurrencyConverter::xmlToEntities($out);
    }


    /**
     * Check given response code and throw Exception if it is not successful
     * @param int $code - response code to check
     * @throws Exception - thrown when response code isn't successful
     */
    protected function checkResponseCode(int $code): void
    {
        if ($code != 200 && $code != 204) {
            throw new Exception(isset($this->errors[$code]) ? $this->errors[$code] : 'Undescribed error', $code);
        }
    }
}