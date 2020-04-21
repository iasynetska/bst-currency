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
     * @return array of Currency
     * @throws Exception
     */
    public function getCurrenciesByDate(): array
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://api.nbp.pl/api/exchangerates/tables/a/last/60');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $this->checkResponseCode((int)$code);

        return CurrencyConverter::jsonToEntities($out);
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