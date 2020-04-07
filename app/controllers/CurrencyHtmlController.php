<?php

namespace controllers;

use core\LangManager;
use core\Request;
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
        $selectedDates = $this->getSelectedDates();
        $currencies = $this->currencyService->getCurrencyByDateAndValuteId(
            $selectedDates['from'],
            $selectedDates['to'],
            $this->request->getPostParam('currency'));

        $arr_currencies = [];
        foreach ($currencies as $currency) {
            array_push($arr_currencies, CurrencyConverter::entityToArray($currency));
        }

        echo $this->build(
            dirname(__DIR__, 1) . '/views/index.html.php',
            [
                'title' => $this->langManager->getLangParams()['title'],
                'loadButton' => $this->langManager->getLangParams()['loadButton'],
                'showReportButton' => $this->langManager->getLangParams()['showReportButton'],
                'columnNames' => $this->langManager->getLangParams()['columnNames'],
                'currencies' => $arr_currencies,
                'valutes' => CurrencyUtils::getAllCurrencyIds()
            ]
        );
    }


    public function handleCurrencyGetRequest()
    {
        echo $this->build(
            dirname(__DIR__, 1) . '/views/index.html.php',
            [
                'title' => $this->langManager->getLangParams()['title'],
                'loadButton' => $this->langManager->getLangParams()['loadButton'],
                'showReportButton' => $this->langManager->getLangParams()['showReportButton'],
                'columnNames' => $this->langManager->getLangParams()['columnNames'],
                'currencies' => [],
                'valutes' => CurrencyUtils::getAllCurrencyIds()
            ]
        );
    }


    private function getSelectedDates(): array
    {
        $from = date('Y-m-d', strtotime($this->request->getPostParam('from')));
        $to = date('Y-m-d', strtotime($this->request->getPostParam('to')));

        return array('from' => $from, 'to' => $to);
    }

    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include $template;

        return ob_get_clean();
    }
}