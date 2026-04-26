<?php

define('CacheServiceEnabled', !getenv('ENABLE_CACHE') || getenv('ENABLE_CACHE') === "true");

class CacheService
{
    public const FIVE_MINUTES = 300;
    public const FIVE_SECONDS = 5;

    public static function memoize(callable $callback, array $dependencies, int $duration = self::FIVE_MINUTES): mixed
    {
        if (!CacheServiceEnabled) {
            return $callback();
        }

        $key = self::serializeKey($dependencies);

        if (!apcu_exists($key)) {
            apcu_add($key, $callback(), $duration);
        }

        return apcu_fetch($key);
    }

    public static function invalidate(array $dependencies): void
    {
        apcu_delete(self::serializeKey($dependencies));
    }

    public static function invalidateAll(): void
    {
        apcu_clear_cache();
    }

    private static function serializeKey(array $dependencies): string {
        $serializedDependencies = array_map(function ($dependency) {
            if (is_scalar($dependency)) {
                return $dependency;
            }

            return serialize($dependency);
        }, $dependencies);

        return join("|", $serializedDependencies);
    }
}
