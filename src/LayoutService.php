<?php

require_once __DIR__ . "/VersionService.php";

class LayoutService
{
    public static function renderHeaders(string $title): void
    {
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars("Sun & String - " . $title) ?></title>
        <link rel="stylesheet" href="https://matcha.mizu.sh/matcha.css">
        <link rel="icon" type="image/x-icon" href="/static/favicon.ico?version=<?= VersionService::getVersion() ?>">
        <link rel="stylesheet" href="/static/index.css?version=<?= VersionService::getVersion() ?>">
        <?php
    }

    public static function renderNavigation(): void
    {
        ?>
        <nav style="display: flex; align-items: center; position: relative; padding: 4px; background-color: #f5f5f5; border-bottom: 1px solid #e0e0e0;">
            <a href="/" style="display: block; line-height: 0;">
                <img src="/static/logo.png?version=<?= VersionService::getVersion() ?>" alt="Logo" style="height: 60px; width: auto; display: block;">
<!--                @TODO link to products page -->
            </a>
            <div style="position: absolute; right: 1.5rem;">
                <!-- Right side content: login button / avatar will go here -->
            </div>
        </nav>
        <?php
    }
}
