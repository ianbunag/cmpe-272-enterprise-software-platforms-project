<?php

class DatabaseService
{
    public static function getPdo(): PDO
    {
        return new PDO(
            'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8mb4',
            getenv('DB_USER'),
            getenv('DB_PASSWORD')
        );
    }
}
