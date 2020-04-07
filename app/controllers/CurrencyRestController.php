<?php

namespace controllers;

use core\LangManager;
use core\Request;
use DateTime;
use entities\CurrencyConverter;
use services\CurrencyService;

class CurrencyRestController extends AbstractController
{
    private $currencyService;

    public function __construct(Request $request, LangManager $langManager, CurrencyService $currencyService)
    {
        parent::__construct($request, $langManager);
        $this->currencyService = $currencyService;
    }

    public function handleCurrencyPostRequest()
    {
        $this->currencyService->populateDbWithCurrencies();
        header(sprintf('Location: %s', '/'));
    }


    public function handleCurrencyGetRequest()
    {
        $selectedDates = $this->getSelectedDates();
        $currencies = $this->currencyService->getCurrencyByDateAndValuteId(
            $selectedDates['from'],
            $selectedDates['to'],
            $this->request->getGetParam('valueID'));

        $arr_currencies = [];
        foreach ($currencies as $currency) {
            array_push($arr_currencies, CurrencyConverter::entityToArray($currency));
        }

        echo json_encode($arr_currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    private function getSelectedDates(): array
    {
        $from = $this->request->getGetParam('from');
        $to = $this->request->getGetParam('to');

        if(!$this->validateDate($from) || !$this->validateDate($to))
        {
            http_response_code(400);
            echo sprintf("Date format is incorrect. Date should be formatted as %s", $this::DATE_FORMAT);
            exit();
        }

        return array('from' => $from, 'to' => $to);
    }


    function validateDate($date)
    {
        $formattedDate = DateTime::createFromFormat($this::DATE_FORMAT, $date);
        return $formattedDate && $formattedDate->format($this::DATE_FORMAT) === $date;
    }
}