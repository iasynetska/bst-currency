<?php
namespace core;

class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    
    private $get;
    private $post;
    private $server;

    public function __construct($get, $post, $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    public function getMethod()
    {
        return $this->getServerParam('REQUEST_METHOD');
    }
    
    public function getSessionParam($key)
    {
        return $this->getParam($_SESSION, $key);
    }
    
    public function addSessionParam($key, $param)
    {
        $_SESSION[$key] = $param;
    }
    
    public function deleteSessionParam($key)
    {
        unset($_SESSION[$key]);
    }
    
    public function getServerParam($key)
    {
        return $this->getParam($this->server, $key);
    }
    
    public function getGetParam($key)
    {
        return $this->isGetParam($key) ? $this->getParam($this->get, $key) : null;
    }
    
    public function getGetParams()
    {
        return $this->get;
    }
    
    public function addGetParam($key, $param)
    {
        $this->get[$key] = $param;
    }
    
    public function isGet()
    {
        return $this->getMethod() === self::METHOD_GET;
    }
    
    private function isGetParam($key)
    {
        return isset($this->get[$key]);
    }
    
    public function getPostParam($key)
    {
        return $this->getParam($this->post, $key);
    }
    
    public function addPostParam($key, $param)
    {
        $this->post[$key] = $param;
    }
    
    public function isPost()
    {
        return $this->getMethod() === self::METHOD_POST;
    }

    public function getRequestUri()
    {
        return $this->getServerParam('REQUEST_URI');
    }
    
    private function getParam(array $arr, $key)
    {        
        if (isset($arr[$key])) 
        {
            return $arr[$key];
        }
        return NULL;
    }
}