<?php

class EnvironmentService
{
    private static array $cache = [];

    public static function getDbHost(): array|false|string
    {
        return self::getCachedEnv('DB_HOST');
    }

    public static function getDbName(): array|false|string
    {
        return self::getCachedEnv('DB_NAME');
    }

    public static function getDbUser(): array|false|string
    {
        return self::getCachedEnv('DB_USER');
    }

    public static function getDbPassword(): array|false|string
    {
        return self::getCachedEnv('DB_PASSWORD');
    }

    public static function getEnableCache(): array|false|string
    {
        return self::getCachedEnv('ENABLE_CACHE');
    }

    public static function getVersion(): array|false|string
    {
        return self::getCachedEnv('VERSION');
    }

    public static function getSupportEmail(): array|false|string
    {
        return self::getCachedEnv('SUPPORT_EMAIL');
    }

    private static function getCachedEnv(string $key): array|false|string
    {
        if (!array_key_exists($key, self::$cache)) {
            self::$cache[$key] = getenv($key);
        }

        return self::$cache[$key];
    }
}
