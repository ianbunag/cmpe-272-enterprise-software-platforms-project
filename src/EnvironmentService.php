<?php

class EnvironmentService
{
    private static array $cache = [];

    public static function getDbHost(): false|string
    {
        return self::getCachedEnv('DB_HOST');
    }

    public static function getDbName(): false|string
    {
        return self::getCachedEnv('DB_NAME');
    }

    public static function getDbUser(): false|string
    {
        return self::getCachedEnv('DB_USER');
    }

    public static function getDbPassword(): false|string
    {
        return self::getCachedEnv('DB_PASSWORD');
    }

    public static function getEnableCache(): false|string
    {
        return self::getCachedEnv('ENABLE_CACHE');
    }

    public static function getVersion(): false|string
    {
        return self::getCachedEnv('VERSION');
    }

    public static function getSupportEmail(): false|string
    {
        return self::getCachedEnv('SUPPORT_EMAIL');
    }

    private static function getCachedEnv(string $key): false|string
    {
        if (!array_key_exists($key, self::$cache)) {
            self::$cache[$key] = getenv($key);
        }

        return self::$cache[$key];
    }
}
