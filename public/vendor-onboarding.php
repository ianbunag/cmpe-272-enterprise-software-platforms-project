<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("For Vendors"); ?>
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
            .content-wrap p {
                font-size: 0.93rem;
                color: #555;
                line-height: 1.8;
                margin: 0 0 1rem;
            }
            .content-wrap ul, .content-wrap ol {
                margin: 0 0 1rem 1.25rem;
                padding: 0;
            }
            .content-wrap ul li, .content-wrap ol li {
                font-size: 0.93rem;
                color: #555;
                line-height: 1.8;
                margin-bottom: 0.3rem;
            }
            .content-wrap strong { color: #111; font-weight: 600; }
            .content-wrap a { color: #c8860a; text-decoration: none; }
            .content-wrap a:hover { text-decoration: underline; }
            .step {
                background: #fff;
                border: 1px solid #ebebeb;
                border-radius: 14px;
                padding: 1.75rem;
                margin-bottom: 1.25rem;
            }
            .step-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 0.75rem;
            }
            .step-number {
                width: 36px;
                height: 36px;
                background: #f9f3e7;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
                font-weight: 800;
                color: #c8860a;
                flex-shrink: 0;
            }
            .step h2 {
                font-size: 1rem;
                font-weight: 700;
                color: #111;
                margin: 0;
            }
            .step p, .step ul, .step ol { margin-bottom: 0; }
            .step p + p, .step p + ul, .step p + ol { margin-top: 0.75rem; }
            .code-block {
                background: #f5f5f5;
                border: 1px solid #e5e5e5;
                border-radius: 8px;
                padding: 0.75rem 1rem;
                font-family: monospace;
                font-size: 0.85rem;
                color: #333;
                margin-top: 0.75rem;
                word-break: break-all;
            }
            .schema-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.88rem;
                margin-top: 0.75rem;
            }
            .schema-table th {
                text-align: left;
                padding: 0.6rem 0.75rem;
                background: #f9f3e7;
                color: #111;
                font-weight: 600;
                border-bottom: 1px solid #e8ddc8;
            }
            .schema-table td {
                padding: 0.6rem 0.75rem;
                border-bottom: 1px solid #f0f0f0;
                color: #555;
                vertical-align: top;
            }
            .schema-table code {
                background: #f0f0f0;
                padding: 0.1rem 0.35rem;
                border-radius: 4px;
                font-size: 0.82rem;
                color: #c8860a;
            }
            .cta-box {
                background: #f9f3e7;
                border-radius: 14px;
                padding: 2rem;
                text-align: center;
                margin-top: 2.5rem;
            }
            .cta-box h2 {
                font-size: 1.2rem;
                font-weight: 700;
                color: #111;
                margin: 0 0 0.5rem;
            }
            .cta-box p { color: #777; margin: 0 0 1.25rem; font-size: 0.9rem; }
            .btn-primary {
                display: inline-block;
                padding: 0.75rem 1.75rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 700;
                font-size: 0.9rem;
            }
            .btn-primary:hover { background: #333; }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>

        <div class="page-banner">
            <h1>Become a Vendor</h1>
            <p>Join Sun &amp; String and reach customers looking for curated products.</p>
        </div>

        <div style="background: #fff;">
            <div class="content-wrap">
                <p>Listing your products on Sun &amp; String takes just three steps. Follow the guide below or refer to our <a href="https://github.com/ianbunag/cmpe-272-enterprise-software-platforms-project/blob/main/CONTRIBUTING.md#adding-your-company-to-the-marketplace" target="_blank" rel="noopener noreferrer">Developer Guide</a> for full technical documentation.</p>

                <div class="step">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <h2>Add Your Company to the Database</h2>
                    </div>
                    <p>Contact our support team to provision your company account. You will need to provide:</p>
                    <ul>
                        <li><strong>Company Name:</strong> Your official business name</li>
                        <li><strong>Products API URL:</strong> The public endpoint where your products are hosted</li>
                    </ul>
                </div>

                <div class="step">
                    <div class="step-header">
                        <div class="step-number">2</div>
                        <h2>Expose a Product API Endpoint</h2>
                    </div>
                    <p>Your website must provide a public HTTPS endpoint that returns your product list in JSON format. The endpoint must:</p>
                    <ul>
                        <li>Be accessible via HTTPS</li>
                        <li>Respond to <code style="background:#f0f0f0;padding:0.1rem 0.35rem;border-radius:4px;font-size:0.82rem;color:#c8860a;">GET</code> requests</li>
                        <li>Return a JSON array of products matching our specification</li>
                    </ul>
                </div>

                <div class="step">
                    <div class="step-header">
                        <div class="step-number">3</div>
                        <h2>Match the OpenAPI Specification</h2>
                    </div>
                    <p>Each product in your JSON response must include these fields:</p>
                    <table class="schema-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>id</code></td><td>string</td><td>Unique identifier within your catalog</td></tr>
                            <tr><td><code>name</code></td><td>string</td><td>Product name or title</td></tr>
                            <tr><td><code>price</code></td><td>string</td><td>Price (e.g. "$19.99" or "$5/lb")</td></tr>
                            <tr><td><code>description</code></td><td>string</td><td>Product description or summary</td></tr>
                            <tr><td><code>imageUrl</code></td><td>string</td><td>URL to the product image</td></tr>
                            <tr><td><code>url</code></td><td>string</td><td>Link to your product page</td></tr>
                        </tbody>
                    </table>
                    <p style="margin-top:0.75rem;">View a working example at:</p>
                    <div class="code-block">
                        <a href="<?= htmlspecialchars(VersionService::getHost() . '/api/test/products') ?>" target="_blank" rel="noopener noreferrer">
                            <?= htmlspecialchars(VersionService::getHost() . '/api/test/products') ?>
                        </a>
                    </div>
                </div>

                <div class="cta-box">
                    <h2>Ready to Get Started?</h2>
                    <p>Send us your company name and products API URL and we'll get you set up.</p>
                    <a href="mailto:<?= EnvironmentService::getSupportEmail(); ?>" class="btn-primary">Contact Us</a>
                </div>
            </div>
        </div>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
