<?php
require_once __DIR__ . '/SessionService.php';

class UserService
{
    public static function getId(): string
    {
        return SessionService::getUserId() ?? "anonymous";
    }

    public static function getDisplayName(): string
    {
        return SessionService::getUserDisplayName() ?? "Anonymous";
    }

    public static function getImageUrl(): ?string
    {
        return SessionService::getUserImageUrl();
    }

    public static function getInitials(): string
    {
        $name = trim(self::getDisplayName());
        $parts = explode(' ', $name);
        $firstInitial = substr($parts[0], 0, 1);

        if (count($parts) > 1) {
            $lastInitial = substr(end($parts), 0, 1);
            return strtoupper($firstInitial . $lastInitial);
        }

        return strtoupper($firstInitial);
    }
}