<?php

namespace controllers;

use core\RequestValidator;
use core\LangManager;
use core\Request;
use core\CurrencyValidatort;
use currencies\CurrencyUtils;
use entities\CurrencyConverter;
use services\CurrencyService;

class CurrencyHtmlController extends AbstractController
{
    private $currencyService;

    public function __construct(Request $request, LangManager $langManager, CurrencyService $currencyService)
    {
        parent::__construct($request, $langManager);
        $this->currencyService = $currencyService;
    }

    public function handleCurrencyPostRequest()
    {
        $currencySelectedCode = $this->request->getPostParam('currency');
        $selectedFromDate = $this->request->getPostParam('from');
        $selectedToDate = $this->request->getPostParam('to');

        $currencyValidator = new RequestValidator($this->langManager);
        $validationErrorMessages = $currencyValidator->validateDataForCurrencyReport($currencySelectedCode, $selectedFromDate, $selectedToDate);


        if(!empty($validationErrorMessages))
        {
            http_response_code(400);
            echo json_encode($validationErrorMessages);
            exit();
        }

        $minDate = $this->currencyService->getMinAndMaxDate()["minDate"];
        $maxDate = $this->currencyService->getMinAndMaxDate()["maxDate"];
        $actualInformation = isset($minDate) && isset($maxDate) ? sprintf($this->langManager->getLangParam('currencyAvailability'), $minDate, $maxDate) : $this->langManager->getLangParam('emptyDatabase');

        $currencies = $currencySelectedCode === "ALL" ? $this->currencyService->getCurrenciesByDateRange($selectedFromDate, $selectedToDate) : $this->currencyService->getCurrencyByDateAndCurrencyCode($selectedFromDate, $selectedToDate, $currencySelectedCode);

        $arr_currencies = [];
        foreach ($currencies as $currency) {
            array_push($arr_currencies, CurrencyConverter::entityToArray($currency));
        }

        echo $this->build(
            dirname(__DIR__, 1) . '/views/index.html.php',
            [
                'title' => $this->langManager->getLangParam('title'),
                'loadButton' => $this->langManager->getLangParam('loadButton'),
                'actualInformation' => $actualInformation,
                'allCurrencies' => $this->langManager->getLangParam('allCurrencies'),
                'showReportButton' => $this->langManager->getLangParam('showReportButton'),
                'columnNames' => $this->langManager->getLangParam('columnNames'),
                'currencies' => $arr_currencies,
                'currencySelectedCode' => $currencySelectedCode,
                'selectedFromDate' => $selectedFromDate,
                'selectedToDate' => $selectedToDate,
                'currencyCodes' => CurrencyUtils::getAllCurrencyIds()
            ]
        );
    }


    public function handleCurrencyGetRequest()
    {
        $minMaxDates = $this->currencyService->getMinAndMaxDate();
        $minDate = $minMaxDates["minDate"];
        $maxDate = $minMaxDates["maxDate"];
        $actualInformation = isset($minDate) && isset($maxDate) ? sprintf($this->langManager->getLangParam('currencyAvailability'), $minDate, $maxDate) : $this->langManager->getLangParam('emptyDatabase');

        $arr_currencies = [];

        if(isset($maxDate))
        {
            $currencies =  $this->currencyService->getCurrenciesByDate($maxDate);
            foreach ($currencies as $currency) {
                $arr_currencies[$currency->getCode()] = CurrencyConverter::entityToArray($currency);
            }
        }

        echo $this->build(
            dirname(__DIR__, 1) . '/views/index.html.php',
            [
                'title' => $this->langManager->getLangParam('title'),
                'loadButton' => $this->langManager->getLangParam('loadButton'),
                'actualInformation' => $actualInformation,
                'allCurrencies' => $this->langManager->getLangParam('allCurrencies'),
                'showReportButton' => $this->langManager->getLangParam('showReportButton'),
                'columnNames' => $this->langManager->getLangParam('columnNames'),
                'currencySelectedCode' => null,
                'selectedFromDate' => isset($maxDate) ? $maxDate : null,
                'selectedToDate' => isset($maxDate) ? $maxDate : null,
                'currencies' => $arr_currencies,
                'currencyCodes' => CurrencyUtils::getAllCurrencyIds()
            ]
        );
    }

    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include $template;

        return ob_get_clean();
    }
}