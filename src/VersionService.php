<?php

define('VersionServiceEnvironmentVersion', (string) getenv('VERSION'));

class VersionService
{
    private static string $filePath = __DIR__ . '/../VERSION';

    private static ?string $version = VersionServiceEnvironmentVersion;

    public static function getVersion(): string
    {
        if (self::$version === '') {
            if (!file_exists(self::$filePath)) {
                self::$version = "0.0." . time();
            } else {
                self::$version = trim(file_get_contents(self::$filePath));
            }
        }

        return self::$version;
    }
}
