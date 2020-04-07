<?php

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

$request = new Request($_GET, $_POST);
$langManager = new LangManager($request);
$currencyService = new CurrencyService(new CurrencyDbRepository(DbConnection::getPDO()));
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