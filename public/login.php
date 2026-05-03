<?php require_once __DIR__ . '/../src/index.php'; ?>
<?php
    // Validate and sanitize returnTo parameter - only allow internal URLs
    $returnTo = '/';
    if (isset($_GET['returnTo'])) {
        $parsedUrl = parse_url(urldecode($_GET['returnTo']));
        // Ensure it's a path-only URL (no scheme/host) and starts with /
        if (is_array($parsedUrl) && isset($parsedUrl['path']) && strpos($parsedUrl['path'], '/') === 0 && !isset($parsedUrl['scheme']) && !isset($parsedUrl['host'])) {
            $returnTo = urldecode($parsedUrl['path']);
            if (isset($parsedUrl['query'])) {
                $returnTo .= '?' . $parsedUrl['query'];
            }
        }
    }

    if (SessionService::isAuthenticated()) {
        header("Location: $returnTo");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            LayoutService::renderHeaders("Login");
            SessionService::initializeLogin();
        ?>
        <style>
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }
            #login-container {
                background: white;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
                padding: 2.5rem 2rem;
                margin: 1rem;
            }
            #login-header {
                text-align: center;
                margin-bottom: 2rem;
            }
            #login-logo {
                height: 60px;
                width: auto;
                margin-bottom: 1rem;
            }
            #login-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: #111;
                margin: 0.5rem 0 0;
            }
            #login-subtitle {
                font-size: 0.9rem;
                color: #666;
                margin: 0.5rem 0 0;
            }
            #firebaseui-auth-container {
                margin-top: 1.5rem;
            }
            #firebaseui-auth-container form {
                background: inherit;
            }
            #login-footer {
                text-align: center;
                margin-top: 2rem;
                font-size: 0.8rem;
                color: #999;
            }
            #login-footer a {
                color: #007bff;
                text-decoration: none;
            }
            #login-footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div id="login-container">
            <div id="login-header">
                <a href="/" style="display: block; line-height: 0; text-decoration: none;">
                    <img src="/static/logo.png?version=<?= VersionService::getVersion() ?>" alt="Logo" id="login-logo">
                </a>
                <p id="login-subtitle">Your marketplace for curated products</p>
            </div>

            <div id="firebaseui-auth-container"></div>

            <div id="login-footer">
                <p style="margin: 0;">
                    By signing in, you agree to our<br>
                    <a href="/terms">Terms of Service</a> and <a href="/privacy">Privacy Policy</a>
                </p>
            </div>
        </div>

        <script>
            window.sessionService.login("#firebaseui-auth-container", <?php echo json_encode($returnTo); ?>);
        </script>
    </body>
</html>
