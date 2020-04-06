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
                '%s:host=%s;charset=%s;dbname=%s;user=%s;password=%s',
                $appConfig->getDbType(),
                $appConfig->getDbHost(),
                $appConfig->getDbEncoding(),
                $appConfig->getDbName(),
                $appConfig->getDbUser(),
                $appConfig->getDbPassword()
            );

            self::$pdo = new \PDO(
                $connectionParams,
                [PDO::ATTR_EMULATE_PREPARES=>false,
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }
}