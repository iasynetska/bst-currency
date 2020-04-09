<?php

namespace core;

class LangManager
{
    private $request;
    private $langParams;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function getLangParams(): array
    {
        if(!isset($this->langParams))
        {
            $this->langParams = include (dirname(__DIR__, 1)). '/languages/en.php';
        }
        return $this->langParams;
    }

    public function getLangParam(String $name)
    {
        return $this->getLangParams()[$name];
    }
}
