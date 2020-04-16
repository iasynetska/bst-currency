<?php


namespace core;
use controllers\CurrencyHtmlController;
use controllers\CurrencyRestController;

class RequestRouter
{
    /**
     * @param Request $request
     * @return array which contains keys 'controller' and 'controllerMethod'
     */
    public static function getRequestRoute(Request $request): array
    {
        $controller = null;
        $controllerMethod = null;

        $uri = strtolower(explode('?', $request->getRequestUri())[0]);
        $uriParts = explode('/', $uri);
        unset($uriParts[0]);
        $uriParts = array_values($uriParts);

        if(isset($uriParts[0]) && $uriParts[0] === '')
        {
            $controller = CurrencyHtmlController::class;
            switch($request->getMethod())
            {
                case $request::METHOD_POST:
                    $controllerMethod = 'handleCurrencyPostRequest';
                    break;
                case $request::METHOD_GET:
                    $controllerMethod = 'handleCurrencyGetRequest';
                    break;
            }
            return self::prepareRoute($controller, $controllerMethod);
        }
        elseif ($uriParts[0] === 'api') {
            $controller = CurrencyRestController::class;
            if (isset($uriParts[1]) && $uriParts[1] === 'currencies') {
                switch ($request->getMethod()) {
                    case $request::METHOD_GET:
                        $controllerMethod = 'handleCurrencyGetRequest';
                        break;
                }
            }
            elseif (isset($uriParts[1]) && $uriParts[1] === 'loaddata') {
                switch ($request->getMethod()) {
                    case $request::METHOD_POST:
                        $controllerMethod = 'handleCurrencyPostRequest';
                        break;
                }
            }
            elseif (isset($uriParts[1]) && $uriParts[1] === 'messages') {
                switch ($request->getMethod()) {
                    case $request::METHOD_GET:
                        $controllerMethod = 'handleMessageGetRequest';
                        break;
                }
            }
            return self::prepareRoute($controller, $controllerMethod);
        }
        else
        {
            return self::prepareRoute($controller, $controllerMethod);
        }
    }


    /**
     * If 'controller' and 'controllerMethod' are not empty then return route, otherwise - empty array
     * @param String|null $controller
     * @param String|null $controllerMethod
     * @return array which contains keys 'controller' and 'controllerMethod'
     */
    private static function prepareRoute(?String $controller, ?String $controllerMethod)
    {
        if(isset($controller) && isset($controllerMethod))
        {
            return  array('controller' => $controller, 'controllerMethod' => $controllerMethod);
        }
        else
        {
            return array();
        }
    }
}