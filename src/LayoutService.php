<?php

require_once __DIR__ . "/VersionService.php";

class LayoutService
{
    public static function renderHeaders(string $title): void
    {
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?></title>
        <!-- @TODO -->
        <!-- <link rel="icon" type="image/x-icon" href="/static/favicon.ico"> -->
        <link rel="stylesheet" href="/static/index.css?version=<?= VersionService::getVersion() ?>">
        <?php
    }
}
