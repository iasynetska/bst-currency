<?php


namespace core;


final class AppConfig
{
    private $dbType;
    private $dbHost;
    private $dbEncoding;
    private $dbUser;
    private $dbPassword;
    private $dbName;

    public function __construct()
    {
        $this->dbType = 'mysql';
        $this->dbHost = getenv('BST_DB_HOST');
        $this->dbEncoding = 'utf8';
        $this->dbUser = getenv('BST_DB_USER');
        $this->dbPassword = getenv('BST_DB_PASSWORD');
        $this->dbName = getenv('BST_DB_NAME');
    }

    public function getDbType()
    {
        return $this->dbType;
    }

    public function getDbHost()
    {
        return $this->dbHost;
    }

    public function getDbEncoding()
    {
        return $this->dbEncoding;
    }

    public function getDbUser()
    {
        return $this->dbUser;
    }

    public function getDbPassword()
    {
        return $this->dbPassword;
    }

    public function getDbName()
    {
        return $this->dbName;
    }
}