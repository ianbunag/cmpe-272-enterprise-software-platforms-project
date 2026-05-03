<?php

class SessionService
{
    private static ?array $config = null;

    public static function initialize(): void
    {
        ?>
            <script src="https://www.gstatic.com/firebasejs/12.12.1/firebase-app-compat.js"></script>
            <script src="https://www.gstatic.com/firebasejs/12.12.1/firebase-auth-compat.js"></script>
            <script src="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.js"></script>
            <link type="text/css" rel="stylesheet" href="https://www.gstatic.com/firebasejs/ui/6.0.1/firebase-ui-auth.css" />
            <script>
                firebase.initializeApp({
                    apiKey: <?php echo json_encode(self::getConfig()["apiKey"]); ?>,
                    authDomain: <?php echo json_encode(self::getConfig()["authDomain"]); ?>,
                    projectId: <?php echo json_encode(self::getConfig()["projectId"]); ?>,
                    storageBucket: <?php echo json_encode(self::getConfig()["storageBucket"]); ?>,
                    messagingSenderId: <?php echo json_encode(self::getConfig()["messagingSenderId"]); ?>,
                    appId: <?php echo json_encode(self::getConfig()["appId"]); ?>,
                });

                const sessionService = (() => {
                    function createSession(token, user) {
                        document.cookie = `firebaseToken=${token}; path=/; SameSite=Lax`;
                        document.cookie = `firebaseUserId=${user.providerData[0].providerId}:${user.providerData[0].uid}; path=/; SameSite=Lax`;
                        document.cookie = `firebaseDisplayName=${user.displayName}; path=/; SameSite=Lax`;

                        if (user.photoURL) {
                            document.cookie = `firebaseImageUrl=${user.photoURL}; path=/; SameSite=Lax`;
                        }
                    }

                    function clearSession() {
                        document.cookie = "firebaseToken=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                        document.cookie = "firebaseUserId=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                        document.cookie = "firebaseDisplayName=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                        document.cookie = "firebaseImageUrl=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC";
                    }

                    function login(container, returnTo = '/') {
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
                                        sessionService.createSession(idToken, user);
                                        window.location.assign(returnTo);
                                    });

                                    return false;
                                },
                            },
                        });
                    }

                    function signOut() {
                        firebase.auth().signOut()
                            .then(() => {
                                clearSession()
                                window.location.assign('/');
                            }).catch((error) => {
                                console.error("Sign out error", error);
                            });
                    }

                    return {
                        createSession,
                        clearSession,
                        login,
                        signOut,
                    }
                })();

                firebase.auth().onIdTokenChanged(async (user) => {
                    if (user) {
                        sessionService.createSession(await user.getIdToken(), user);
                        return;
                    }

                    sessionService.clearSession();
                })
            </script>
        <?php
    }

    /**
     * For rapid prototyping purposes, verifying the token is valid suffices.
     *
     * In production, you should verify the token's signature and claims using Firebase Admin SDK.
     */
    public static function isAuthenticated(): bool
    {
        if (!isset($_COOKIE['firebaseToken'])) {
            return false;
        }

        $parts = explode('.', $_COOKIE['firebaseToken']);

        if (count($parts) === 3) {
            $payload = json_decode(base64_decode($parts[1]), true);
            $currentTime = time();

            if ($payload['exp'] > $currentTime) {
                return true;
            }

            return false;
        }

        return false;
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

        return $_COOKIE['firebaseUserId'];
    }

    public static function getUserDisplayName(): ?string
    {
        if (!isset($_COOKIE['firebaseDisplayName'])) {
            return null;
        }

        return $_COOKIE['firebaseDisplayName'];
    }

    public static function getUserImageUrl(): ?string
    {
        if (!isset($_COOKIE['firebaseImageUrl'])) {
            return null;
        }

        return $_COOKIE['firebaseImageUrl'];
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
