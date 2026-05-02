<?php

class DatabaseService
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4',
                getenv('DB_USER'),
                getenv('DB_PASSWORD')
            );
        }
        return self::$pdo;
    }
}
