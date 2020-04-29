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
}