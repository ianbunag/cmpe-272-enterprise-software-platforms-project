<?php

class VersionService
{
    private static string $filePath = __DIR__ . '/../VERSION';

    public static function getVersion(): string
    {
        if (!file_exists(self::$filePath)) {
            return "0.0." . time();
        }

        return trim(file_get_contents(self::$filePath));
    }
}
