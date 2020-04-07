<?php
namespace controllers;

use core\LangManager;
use core\Request;

abstract class AbstractController
{
    protected $request;
    protected $langManager;
    
    public function __construct(Request $request, LangManager $langManager)
    {
        $this->request = $request;
        $this->langManager = $langManager;
    }
    
    protected function checkRequestMethod(String $method)
    {
        $methodCorrect = false;
        switch($method)
        {
            case $this->request::METHOD_POST:
                $methodCorrect = $this->request->isPost();
                break;
            case $this->request::METHOD_GET:
                $methodCorrect = $this->request->isGet();
                break;
        }
        if(!$methodCorrect)
        {
            $this->exitWithMethodError($method);
        }
    }

    protected function exitWithMethodError(String $method)
    {
        http_response_code(400);
        echo sprintf("Request type - %s isn't support for uri: %s", $method, $this->request->getServerParam('REQUEST_URI'));
        exit();
    }
}