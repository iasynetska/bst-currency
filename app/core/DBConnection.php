<?php

namespace core;

use \PDO;

class DbConnection
{
    private static $pdo;

    public static function getPDO(): PDO
    {
        if (!isset(self::$pdo)) {
            $appConfig = new AppConfig();

            $connectionParams = sprintf(
                '%s:host=%s;charset=%s;dbname=%s',
                $appConfig->getDbType(),
                $appConfig->getDbHost(),
                $appConfig->getDbEncoding(),
                $appConfig->getDbName()
            );

            self::$pdo = new \PDO(
                $connectionParams,
                $appConfig->getDbUser(),
                $appConfig->getDbPassword(),
                [PDO::ATTR_EMULATE_PREPARES=>false,
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }
}