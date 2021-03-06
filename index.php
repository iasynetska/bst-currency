<?php

use apiclients\NbpCurrencyApiClient;
use core\DbConnection;
use core\Request;
use core\LangManager;
use core\RequestRouter;
use repositories\CurrencyDbRepository;
use services\CurrencyService;

//auto-load Classes
spl_autoload_register(function ($classname)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR .'app' .DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
});
session_start();

$request = new Request($_GET, $_POST, $_SERVER);
$route = RequestRouter::getRequestRoute($request);

if(empty($route))
{
    http_response_code(404);
    echo sprintf("Uri %s %s not found", $request->getMethod(), $request->getRequestUri());
    exit();
}

$langManager = new LangManager($request);
$currencyService = new CurrencyService(new CurrencyDbRepository(DbConnection::getPDO()), new NbpCurrencyApiClient());

$controller = new $route['controller']($request, $langManager, $currencyService);
$controllerMethod = $route['controllerMethod'];
$controller->$controllerMethod();