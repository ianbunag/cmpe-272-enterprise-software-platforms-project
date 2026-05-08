<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Terms of Service"); ?>
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
            <h1>Terms of Service</h1>
            <p>Last Updated: May 02, 2026</p>
        </div>

        <div style="background: #fff;">
            <div class="content-wrap">
                <h2>1. Agreement to Terms</h2>
                <p>By accessing and using the Sun &amp; String marketplace, you agree to be bound by these Terms of Service. If you do not agree to abide by the above, please do not use this service.</p>

                <hr class="divider">

                <h2>2. Use License</h2>
                <p>Permission is granted to temporarily download one copy of the materials on Sun &amp; String for personal, non-commercial transitory viewing only. Under this license you may not:</p>
                <ul>
                    <li>Modify or copy the materials</li>
                    <li>Use the materials for any commercial purpose or public display</li>
                    <li>Attempt to decompile or reverse engineer any software on Sun &amp; String</li>
                    <li>Remove any copyright or proprietary notations from the materials</li>
                    <li>Transfer the materials to another person or mirror them on any other server</li>
                </ul>

                <hr class="divider">

                <h2>3. Disclaimer</h2>
                <p>The materials on Sun &amp; String are provided on an 'as is' basis. Sun &amp; String makes no warranties, expressed or implied, and hereby disclaims all other warranties including implied warranties of merchantability, fitness for a particular purpose, or non-infringement of intellectual property.</p>

                <hr class="divider">

                <h2>4. Limitations</h2>
                <p>In no event shall Sun &amp; String or its suppliers be liable for any damages arising out of the use or inability to use the materials on Sun &amp; String, even if Sun &amp; String has been notified of the possibility of such damage.</p>

                <hr class="divider">

                <h2>5. Accuracy of Materials</h2>
                <p>The materials on Sun &amp; String could include technical, typographical, or photographic errors. Sun &amp; String does not warrant that any materials on its website are accurate, complete, or current, and may make changes at any time without notice.</p>

                <hr class="divider">

                <h2>6. Links</h2>
                <p>Sun &amp; String has not reviewed all linked sites and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement. Use of any linked website is at the user's own risk.</p>

                <hr class="divider">

                <h2>7. Modifications</h2>
                <p>Sun &amp; String may revise these Terms of Service at any time without notice. By using this website, you agree to be bound by the then current version of these Terms of Service.</p>

                <hr class="divider">

                <h2>8. Governing Law</h2>
                <p>These Terms of Service are governed by and construed in accordance with the laws of the jurisdiction in which Sun &amp; String operates, excluding its conflicts of law provisions.</p>

                <hr class="divider">

                <h2>9. Contact Us</h2>
                <p>If you have any questions about these Terms of Service, please contact us at <a href="mailto:<?= EnvironmentService::getSupportEmail(); ?>"><?= EnvironmentService::getSupportEmail(); ?></a>.</p>
            </div>
        </div>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
