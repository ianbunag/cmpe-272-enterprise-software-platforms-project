<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Privacy Policy"); ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }
            .page-banner {
                background: #f9f3e7;
                padding: 4rem 1.5rem 3rem;
                text-align: center;
            }
            .page-banner h1 {
                font-size: 2.2rem;
                font-weight: 800;
                color: #111;
                margin: 0 0 0.5rem;
                letter-spacing: -0.02em;
            }
            .page-banner p {
                font-size: 0.95rem;
                color: #999;
                margin: 0;
            }
            .content-wrap {
                max-width: 760px;
                margin: 0 auto;
                padding: 3.5rem 1.5rem 5rem;
            }
            .content-wrap h2 {
                font-size: 1.1rem;
                font-weight: 700;
                color: #111;
                margin: 2.5rem 0 0.6rem;
            }
            .content-wrap h2:first-child { margin-top: 0; }
            .content-wrap p {
                font-size: 0.93rem;
                color: #555;
                line-height: 1.8;
                margin: 0 0 1rem;
            }
            .content-wrap ul {
                margin: 0 0 1rem 1.25rem;
                padding: 0;
            }
            .content-wrap ul li {
                font-size: 0.93rem;
                color: #555;
                line-height: 1.8;
                margin-bottom: 0.3rem;
            }
            .content-wrap strong { color: #111; font-weight: 600; }
            .content-wrap a { color: #c8860a; text-decoration: none; }
            .content-wrap a:hover { text-decoration: underline; }
            .divider {
                border: none;
                border-top: 1px solid #ebebeb;
                margin: 2rem 0;
            }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>

        <div class="page-banner">
            <h1>Privacy Policy</h1>
            <p>Last Updated: May 02, 2026</p>
        </div>

        <div style="background: #fff;">
            <div class="content-wrap">
                <h2>1. Introduction</h2>
                <p>Sun &amp; String is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>

                <hr class="divider">

                <h2>2. Information We Collect</h2>
                <p>We may collect information about you in a variety of ways, including:</p>
                <ul>
                    <li><strong>Personal Data:</strong> Name, email address, and other information you provide when creating an account.</li>
                    <li><strong>Device Data:</strong> Information about your device, including IP address, browser type, and operating system.</li>
                    <li><strong>Usage Data:</strong> Information about your interactions with the site, including pages visited, products viewed, and time spent.</li>
                </ul>

                <hr class="divider">

                <h2>3. Use of Your Information</h2>
                <p>We use the information we collect to:</p>
                <ul>
                    <li>Process your transactions and send related information</li>
                    <li>Send you marketing and promotional communications</li>
                    <li>Respond to your inquiries and provide customer service</li>
                    <li>Monitor and analyze usage patterns and trends</li>
                    <li>Improve the site and user experience</li>
                    <li>Detect and prevent fraudulent transactions and illegal activities</li>
                </ul>

                <hr class="divider">

                <h2>4. Disclosure of Your Information</h2>
                <p>We may share your information in the following circumstances:</p>
                <ul>
                    <li><strong>Service Providers:</strong> Third-party providers who perform services on our behalf.</li>
                    <li><strong>Business Transfers:</strong> If Sun &amp; String is involved in a merger or acquisition, your information may be transferred.</li>
                    <li><strong>Legal Compliance:</strong> We may disclose your information if required by law or legal process.</li>
                </ul>

                <hr class="divider">

                <h2>5. Security of Your Information</h2>
                <p>We use administrative, technical, and physical security measures to protect your personal information. However, no method of transmission over the Internet is completely secure.</p>

                <hr class="divider">

                <h2>6. Cookies</h2>
                <p>The site may use cookies and similar tracking technologies to enhance your experience. You can control cookie settings through your browser preferences.</p>

                <hr class="divider">

                <h2>7. Your Rights</h2>
                <p>Depending on your location, you may have certain rights regarding your personal information, including:</p>
                <ul>
                    <li>The right to access your personal information</li>
                    <li>The right to correct inaccurate information</li>
                    <li>The right to request deletion of your information</li>
                    <li>The right to opt-out of marketing communications</li>
                </ul>

                <hr class="divider">

                <h2>8. Children's Privacy</h2>
                <p>The site is not intended for children under the age of 13. We do not knowingly collect personal information from children under 13. If we become aware of such collection, we will promptly delete the information.</p>

                <hr class="divider">

                <h2>9. Third-Party Links</h2>
                <p>The site may contain links to third-party websites. We are not responsible for their privacy practices and encourage you to review their policies before providing personal information.</p>

                <hr class="divider">

                <h2>10. Changes to This Policy</h2>
                <p>Sun &amp; String may update this Privacy Policy from time to time. We will notify you of significant changes by posting the new policy and updating the date above.</p>

                <hr class="divider">

                <h2>11. Contact Us</h2>
                <p>If you have questions about this Privacy Policy, please contact us at <a href="mailto:<?= EnvironmentService::getSupportEmail(); ?>"><?= EnvironmentService::getSupportEmail(); ?></a>.</p>
            </div>
        </div>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
