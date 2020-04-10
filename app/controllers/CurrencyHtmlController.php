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
                'title' => $this->langManager->getLangParam('title'),
                'loadButton' => $this->langManager->getLangParam('loadButton'),
                'showReportButton' => $this->langManager->getLangParam('showReportButton'),
                'columnNames' => $this->langManager->getLangParam('columnNames'),
                'currencies' => $arr_currencies,
                'currencySelected' => $this->request->getPostParam('currency'),
                'from' => $this->request->getPostParam('from'),
                'to' => $this->request->getPostParam('to'),
                'valutes' => CurrencyUtils::getAllCurrencyIds()
            ]
        );
    }


    public function handleCurrencyGetRequest()
    {
        echo $this->build(
            dirname(__DIR__, 1) . '/views/index.html.php',
            [
                'title' => $this->langManager->getLangParam('title'),
                'loadButton' => $this->langManager->getLangParam('loadButton'),
                'showReportButton' => $this->langManager->getLangParam('showReportButton'),
                'columnNames' => $this->langManager->getLangParam('columnNames'),
                'currencySelected' => null,
                'from' => null,
                'to' => null,
                'currencies' => [],
                'valutes' => CurrencyUtils::getAllCurrencyIds()
            ]
        );
    }


    private function getSelectedDates(): array
    {
        $from = date($this::DATE_FORMAT, strtotime($this->request->getPostParam('from')));
        $to = date($this::DATE_FORMAT, strtotime($this->request->getPostParam('to')));

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