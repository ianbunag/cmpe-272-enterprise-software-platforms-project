<?php

require_once __DIR__ . "/VersionService.php";
require_once __DIR__ . '/SessionService.php';

class LayoutService
{
    public static function requireAuthenticated(): void
    {
        if (!SessionService::isAuthenticated()) {
            $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
            $returnTo = urlencode($currentUrl);
            header("Location: /login?returnTo=$returnTo");
            SessionService::clearAuthentication();
            exit();
        }
    }

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
        SessionService::initialize();
    }

    public static function renderNavigation(): void
    {
        ?>
        <nav style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 1.5rem; background-color: #fdfdfd; border-bottom: 1px solid #ddd; position: relative;">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <a href="/" style="display: block; line-height: 0;">
                    <img src="/static/logo.png?version=<?= VersionService::getVersion() ?>" alt="Logo" style="height: 50px; width: auto; display: block;">
                </a>
                <a href="/products" style="text-decoration: none; color: #111; font-weight: 500;">Products</a>
            </div>

            <div style="position: relative;">
                <?php if (!SessionService::isAuthenticated()): ?>
                    <a href="/login?returnTo=<?php echo urlencode($_SERVER['REQUEST_URI'] ?? '/'); ?>" style="display: inline-block; padding: 0.4rem 1rem; border: 1px solid #111; background-color: #fff; color: #111; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 0.9rem;">Login</a>
                <?php else: ?>
                    <div id="avatar-button" onclick="toggleUserMenu()" style="cursor: pointer; display: flex; align-items: center;">
                        <?php if ($url = UserService::getImageUrl()): ?>
                            <img src="<?= htmlspecialchars((string)$url, ENT_QUOTES, 'UTF-8') ?>" alt="User" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1px solid #ccc;">
                        <?php else: ?>
                            <div style="width: 38px; height: 38px; border-radius: 50%; background-color: #f6f6f6; border: 1px solid #ccc; color: #333; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;">
                                <?= htmlspecialchars(UserService::getInitials()) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div id="user-menu-dropdown" style="display: none; position: absolute; right: 0; top: 48px; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); min-width: 180px; z-index: 1000; padding: 8px;">
                        <div style="padding: 8px; border-bottom: 1px solid #eee; margin-bottom: 8px; font-size: 0.8rem; color: #666; overflow: hidden; text-overflow: ellipsis;">
                            <?= htmlspecialchars(UserService::getDisplayName()) ?>
                        </div>
                        <a href="/" onclick="window.sessionService.signOut(); return false;" style="display: block; padding: 0.4rem 0.8rem; border: 1px solid #ccc; background-color: #f8f8f8; color: #333; text-decoration: none; border-radius: 4px; font-size: 0.85rem; text-align: center; font-weight: 500;">Logout</a>
                    </div>
                <?php endif; ?>
            </div>

            <script>
                function toggleUserMenu() {
                    const menu = document.getElementById('user-menu-dropdown');
                    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                }
                window.addEventListener('click', function(event) {
                    if (!event.target.matches('#avatar-button') && !event.target.closest('#avatar-button')) {
                        const menu = document.getElementById('user-menu-dropdown');
                        if (menu) {
                            menu.style.display = 'none';
                        }
                    }
                })
            </script>
        </nav>
        <?php
    }

    public static function renderFooter(): void
    {
        ?>
        <footer style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; padding: 1.5rem; background-color: #fdfdfd; border-top: 1px solid #ddd; margin-top: 3rem; font-size: 0.85rem; color: #666;">
            <div style="display: flex; gap: 2rem; flex-wrap: wrap; align-items: center;">
                <div>
                    <p style="margin: 0; font-weight: 600; color: #111; margin-bottom: 0.3rem;">Sun & String</p>
                    <p style="margin: 0; font-size: 0.75rem;">Your marketplace for curated products</p>
                </div>
                <div style="display: flex; gap: 1rem; font-size: 0.8rem;">
                    <span>•</span>
                    <a href="mailto:support.sunandstring@ianbunag.dev" style="text-decoration: none; color: #007bff;">support.sunandstring@ianbunag.dev</a>
                </div>
            </div>

            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center;">
                <a href="/terms" style="text-decoration: none; color: #666;">Terms of Service</a>
                <span style="color: #ccc;">•</span>
                <a href="/privacy" style="text-decoration: none; color: #666;">Privacy Policy</a>
                <span style="color: #ccc;">•</span>
                <a href="/vendor-onboarding" style="text-decoration: none; color: #666;">For Vendors</a>
            </div>

            <div style="width: 100%; text-align: center; padding-top: 1rem; border-top: 1px solid #eee; margin-top: 1rem; color: #999; font-size: 0.75rem;">
                <p style="margin: 0;">© <?= date('Y') ?> Sun & String. All rights reserved. v<?= VersionService::getVersion() ?></p>
            </div>
        </footer>
        <?php
    }
}

