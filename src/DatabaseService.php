<?php

require_once __DIR__ . "/EnvironmentService.php";

class DatabaseService
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                'mysql:host=' . EnvironmentService::getDbHost() . ';dbname=' . EnvironmentService::getDbName() . ';charset=utf8mb4',
                EnvironmentService::getDbUser(),
                EnvironmentService::getDbPassword()
            );
        }
        return self::$pdo;
    }
}
