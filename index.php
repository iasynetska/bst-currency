<?php

use controllers\CurrencyRestController;
use core\DbConnection;
use core\Request;
use core\LangManager;
use controllers\CurrencyHtmlController;
use repositories\CurrencyDbRepository;
use services\CurrencyService;

//auto-load Classes
spl_autoload_register(function ($classname)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR .'app' .DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
});
session_start();

$uri = strtolower(explode('?', $_SERVER['REQUEST_URI'])[0]);
$uriParts = explode('/', $uri);
unset($uriParts[0]);
$uriParts = array_values($uriParts);

$controllerType = isset($uriParts[0]) && $uriParts[0] !== '' ? $uriParts[0] : 'http';
$request = new Request($_GET, $_POST);
$langManager = new LangManager($request);
$currencyService = new CurrencyService(new CurrencyDbRepository(DbConnection::getPDO()));

if($controllerType === 'http')
{
    $controller = new CurrencyHtmlController($request, $langManager, $currencyService);
    switch($request->getMethod())
    {
        case $request::METHOD_POST:
            $controller->handleCurrencyPostRequest();
            break;
        case $request::METHOD_GET:
            $controller->handleCurrencyGetRequest();
            break;
    }
} elseif ($controllerType === 'api')
{
    $controller = new CurrencyRestController($request, $langManager, $currencyService);
    switch($request->getMethod())
    {
        case $request::METHOD_POST:
            $controller->handleCurrencyPostRequest();
            break;
        case $request::METHOD_GET:
            $controller->handleCurrencyGetRequest();
            break;
    }
} else {
    http_response_code(404);
    echo sprintf("Uri %s not found", $this->request->getServerParam('REQUEST_URI'));
    exit();
}