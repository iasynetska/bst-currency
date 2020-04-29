<?php

namespace controllers;

use core\LangManager;
use core\Request;
use core\RequestValidator;
use entities\CurrencyConverter;
use Exception;
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
        try
        {
            $this->currencyService->populateDbWithCurrencies();
            $minDate = $this->currencyService->getMinAndMaxDate()["minDate"];
            $maxDate = $this->currencyService->getMinAndMaxDate()["maxDate"];

            echo json_encode(array(
                "message" => $this->langManager->getLangParam('loadSuccess'),
                "actualInformation" => sprintf($this->langManager->getLangParam('currencyAvailability'), $minDate, $maxDate)
            ));
        }
        catch (Exception $e)
        {
            http_response_code(500);
            echo json_encode(array("message" => sprintf( $this->langManager->getLangParam('loadError'), $e->getMessage())));
            exit();
        }
    }


    public function handleCurrencyGetRequest()
    {
        $currencyCode = $this->request->getGetParam("currency");
        $from = $this->request->getGetParam("from");
        $to = $this->request->getGetParam("to");

        $currencyValidator = new RequestValidator($this->langManager);
        $validationErrorMessages = $currencyValidator->validateDataForCurrencyReport($currencyCode, $from, $to);

        if(!empty($validationErrorMessages))
        {
            http_response_code(400);
            echo json_encode($validationErrorMessages);
            exit();
        }

        $currencies = $this->currencyService->getCurrencyByDateAndCurrencyCode($from, $to, $currencyCode);
        $arr_currencies = [];
        foreach ($currencies as $currency) {
            array_push($arr_currencies, CurrencyConverter::entityToArray($currency));
        }

        echo json_encode($arr_currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    public function handleMessageGetRequest()
    {
        $messageName = $this->request->getGetParam("messageName");
        $message = $this->langManager->getLangParam($messageName);

        if(isset($message))
        {
            echo json_encode(array($messageName => $message));
        }
        else
        {
            http_response_code(404);
            echo json_encode(array("error" => sprintf($this->langManager->getLangParam("messageNotFound"), $messageName)));
            exit();
        }
    }
}