<?php
namespace controllers;

use core\LangManager;
use core\Request;
use entities\CurrencyConverter;
use services\CurrencyService;

class CurrencyHtmlController extends AbstractController
{
    private $currencyService;
    private $content;
    
    public function __construct(Request $request, LangManager $langManager, CurrencyService $currencyService)
    {
        parent::__construct($request, $langManager);
        $this->currencyService = $currencyService;
    }

    public function handleCurrencyRequest()
    {
        $selectedDates = $this->getSelectedDates();
        $currencies = $this->currencyService->getCurrencyFromTo($selectedDates['from'], $selectedDates['to']);

        $arr_currencies = [];
        foreach ($currencies as $currency)
        {
            array_push($arr_currencies, CurrencyConverter::entityToArray($currency));
        }

        echo $this->build(
            dirname(__DIR__, 1) . '/views/index.html.php',
            [
                'title'=> $this->langManager->getLangParams()['title'],
                'currencies' => $arr_currencies
            ]
        );
    }

    private function getSelectedDates(): array
    {
        if($this->request->isGet())
        {
            return array('from'=>date('Y-m-d'), 'to'=>date('Y-m-d'));
        }
        else if($this->request->isPost())
        {
            return array('from'=>$this->request->getPostParam('from'), 'to'=>$this->request->getPostParam('to'));
        }
        $this->exitWithMethodError($this->request->getMethod());
    }
    
    protected function build($template, array $params = [])
    {
        ob_start();
        extract($params);
        include $template;
        
        return ob_get_clean();
    }
}