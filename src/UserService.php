<?php

class UserService
{
    public static function isAuthenticated(): bool
    {
        return true;
    }

    public static function getId(): string
    {
        return "test-id";
    }

    public static function getDisplayName(): string
    {
        return "some.one@sjsu.edu";
    }

    public static function getImageUrl(): ?string
    {
        return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmEv7XnCsbPaODoDKRHQwaxr3-KBM4vgaZMw&s";
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