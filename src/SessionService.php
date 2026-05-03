<?php

class SessionService
{
    private static ?array $config = null;

    private static ?bool $isAuthenticated = null;

    public static function initialize(): void
    {
        ?>
            <script src="https://www.gstatic.com/firebasejs/12.12.1/firebase-app-compat.js"></script>
            <script src="https://www.gstatic.com/firebasejs/12.12.1/firebase-auth-compat.js"></script>
            <script>
                firebase.initializeApp({
                    apiKey: <?php echo json_encode(self::getConfig()["apiKey"]); ?>,
                    authDomain: <?php echo json_encode(self::getConfig()["authDomain"]); ?>,
                    projectId: <?php echo json_encode(self::getConfig()["projectId"]); ?>,
                    storageBucket: <?php echo json_encode(self::getConfig()["storageBucket"]); ?>,
                    messagingSenderId: <?php echo json_encode(self::getConfig()["messagingSenderId"]); ?>,
                    appId: <?php echo json_encode(self::getConfig()["appId"]); ?>,
                });

                window.sessionService = (() => {
                    function createSession(token, user) {
                        let maxAgeAttr = "";

                        try {
                            const parts = token.split('.');
                            if (parts.length === 3) {
                                const payload = JSON.parse(atob(parts[1]));
                                const expirationTime = payload.exp * 1000;
                                const maxAge = Math.floor((expirationTime - Date.now()) / 1000);

                                // Only apply max-age if the calculation resulted in a positive number
                                if (maxAge > 0) {
                                    maxAgeAttr = `; max-age=${maxAge}`;
                                }
                            }
                        } catch (error) {
                            // Silently suppress errors and proceed with session cookies
                            console.warn("Could not parse token expiration so falling back to session cookies");
                        }

                        const commonSettings = `; path=/; SameSite=Lax${maxAgeAttr}`;

                        document.cookie = `firebaseToken=${encodeURIComponent(token)}${commonSettings}`;

                        // Safely handle provider data to prevent errors if the array is empty
                        const provider = user.providerData && user.providerData[0] ? user.providerData[0] : { providerId: 'firebase', uid: user.uid };
                        document.cookie = `firebaseUserId=${encodeURIComponent(provider.providerId + ':' + provider.uid)}${commonSettings}`;

                        document.cookie = `firebaseDisplayName=${encodeURIComponent(user.displayName)}${commonSettings}`;

                        if (user.photoURL) {
                            document.cookie = `firebaseImageUrl=${encodeURIComponent(user.photoURL)}${commonSettings}`;
                        }
                    }

                    function clearSession() {
                        document.cookie = "firebaseToken=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                        document.cookie = "firebaseUserId=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                        document.cookie = "firebaseDisplayName=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                        document.cookie = "firebaseImageUrl=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                    }

                    function signOut() {
                        firebase.auth().signOut()
                            .then(() => {
                                clearSession()
                                window.location.assign('/');
                            }).catch((error) => {
                                alert("Error signing out. Please try again.");
                                console.error("Sign out error", error);
                            });
                    }

                    return {
                        createSession,
                        clearSession,
                        signOut,
                    }
                })();

                firebase.auth().onIdTokenChanged(async (user) => {
                    if (user) {
                        window.sessionService.createSession(await user.getIdToken(), user);

                        return;
                    }

                    window.sessionService.clearSession();
                })
            </script>
        <?php
    }

    public static function initializeLogin(): void
    {
        ?>
            <script src="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.js"></script>
            <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.css" />
            <script>
                window.sessionService.login = (container, returnTo = '/') => {
                    new firebaseui.auth.AuthUI(firebase.auth()).start(container, {
                        signInOptions: [
                            firebase.auth.EmailAuthProvider.PROVIDER_ID,
                            firebase.auth.GoogleAuthProvider.PROVIDER_ID,
                            firebase.auth.GithubAuthProvider.PROVIDER_ID
                        ],
                        signInFlow: 'popup',
                        callbacks: {
                            signInSuccessWithAuthResult: function(authResult) {
                                const { user } = authResult;
                                user.getIdToken().then(function(idToken) {
                                    window.sessionService.createSession(idToken, user);
                                    window.location.assign(returnTo);
                                });

                                return false;
                            },
                        },
                    });
                }
            </script>
        <?php
    }

    /**
     * For rapid prototyping purposes, verifying the token has not expired suffices.
     *
     * In production, you should verify the token's signature and claims using Firebase Admin SDK.
     */
    public static function isAuthenticated(): bool
    {
        if (self::$isAuthenticated !== null) {
            return self::$isAuthenticated;
        }

        self::$isAuthenticated = false;

        if (self::getToken() && self::getUserId() && self::getUserDisplayName()) {
            $parts = explode('.', self::getToken());

            if (count($parts) === 3) {
                $payload = json_decode(base64_decode($parts[1]), true);
                $currentTime = time();

                if ($payload['exp'] > $currentTime) {
                    self::$isAuthenticated = true;
                }
            }
        }

        return self::$isAuthenticated;
    }

    public static function clearAuthentication(): void
    {
        setcookie("firebaseToken", "", time() - 3600, "/");
        unset($_COOKIE['firebaseToken']);

        setcookie("firebaseUserId", "", time() - 3600, "/");
        unset($_COOKIE['firebaseUserId']);

        setcookie("firebaseDisplayName", "", time() - 3600, "/");
        unset($_COOKIE['firebaseDisplayName']);

        setcookie("firebaseImageUrl", "", time() - 3600, "/");
        unset($_COOKIE['firebaseImageUrl']);
    }

    public static function getUserId(): ?string
    {
        if (!isset($_COOKIE['firebaseUserId'])) {
            return null;
        }

        return urldecode($_COOKIE['firebaseUserId']);
    }

    public static function getUserDisplayName(): ?string
    {
        if (!isset($_COOKIE['firebaseDisplayName'])) {
            return null;
        }

        return urldecode($_COOKIE['firebaseDisplayName']);
    }

    public static function getUserImageUrl(): ?string
    {
        if (!isset($_COOKIE['firebaseImageUrl'])) {
            return null;
        }

        return urldecode($_COOKIE['firebaseImageUrl']);
    }

    private static function getToken(): ?string
    {
        if (!isset($_COOKIE['firebaseToken'])) {
            return null;
        }

        return urldecode($_COOKIE['firebaseToken']);
    }

    private static function getConfig(): array
    {
        if (self::$config === null) {
            $configPath = __DIR__ . '/../firebase-config.json';

            if (!file_exists($configPath)) {
                error_log("Firebase config file not found at: $configPath");
                return [];
            }

            $configJson = file_get_contents($configPath);
            if ($configJson === false) {
                error_log("Failed to read Firebase config file at: $configPath");
                return [];
            }

            self::$config = json_decode($configJson, true);
            if (self::$config === null) {
                error_log("Failed to parse Firebase config JSON: " . json_last_error_msg());
                return [];
            }
        }

        return self::$config;
    }
}
