<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("For Vendors"); ?>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>

        <main style="max-width: 900px; margin: 2rem auto; padding: 0 1.5rem;">
            <h1>Become a Vendor</h1>

            <p>Join Sun & String and reach millions of customers. Our marketplace connects vendors like you with customers looking for curated products.</p>

            <h2>Getting Started</h2>
            <p>To list your products on Sun & String, follow the steps below. For detailed technical documentation, please refer to our <a href="https://github.com/ianbunag/cmpe-272-enterprise-software-platforms-project/blob/main/CONTRIBUTING.md#adding-your-company-to-the-marketplace" target="_blank" rel="noopener noreferrer">Developer Guide</a>.</p>

            <h2>Step 1: Add Your Company to the Database</h2>
            <p>Contact our support team at <a href="mailto:support.sunandstring@ianbunag.dev">support.sunandstring@ianbunag.dev</a> to provision your company account. You will need to provide:</p>
            <ul>
                <li><strong>Company Name:</strong> Your official business name</li>
                <li><strong>Products API URL:</strong> The endpoint where your products are hosted</li>
            </ul>

            <h2>Step 2: Expose a Product API Endpoint</h2>
            <p>Your website must provide a public HTTP endpoint that returns your product list in JSON format. The endpoint must be:</p>
            <ul>
                <li>Accessible via HTTPS</li>
                <li>Respond to <code>GET /products</code> requests</li>
                <li>Return a JSON array of products matching our specification</li>
            </ul>

            <h2>Step 3: Match the OpenAPI Specification</h2>
            <p>The required API contract is defined in our <a href="https://github.com/ianbunag/cmpe-272-enterprise-software-platforms-project/blob/main/open-api-spec.yaml" target="_blank" rel="noopener noreferrer">OpenAPI Specification</a>.</p>

            <p>To view and validate your API:</p>
            <ol>
                <li>Download the <code>open-api-spec.yaml</code> file from the link above</li>
                <li>Visit <a href="https://editor.swagger.io" target="_blank" rel="noopener noreferrer">Swagger Editor</a></li>
                <li>Paste the contents of the specification file</li>
                <li>Test your endpoint against the specification</li>
            </ol>

            <h2>Product Schema</h2>
            <p>Each product must include the following fields:</p>
            <ul>
                <li><code>id</code> (string): Unique identifier for the product within your catalog</li>
                <li><code>name</code> (string): Product name or title</li>
                <li><code>price</code> (string): Price information (can include currency and units, e.g., "$19.99" or "$5/lb")</li>
                <li><code>description</code> (string): Product description or summary</li>
                <li><code>imageUrl</code> (string): URL to the product image</li>
                <li><code>url</code> (string): Link to your product page</li>
            </ul>

            <h2>Example Endpoint</h2>
            <p>Our test endpoint is available at:</p>
            <p>
                <a href="<?= htmlspecialchars(VersionService::getHost() . "/api/test/products") ?>" target="_blank" rel="noopener noreferrer">
                    <code><?= htmlspecialchars(VersionService::getHost() . "/api/test/products") ?></code>
                </a>
            </p>
            <p>This returns a valid product list in the required format. You can use it as a reference for your implementation.</p>

            <h2>Support & Questions</h2>
            <p>If you have questions or need technical assistance with the integration, please reach out to our support team:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:support.sunandstring@ianbunag.dev">support.sunandstring@ianbunag.dev</a></li>
                <li><strong>GitHub Repository:</strong> <a href="https://github.com/ianbunag/cmpe-272-enterprise-software-platforms-project" target="_blank" rel="noopener noreferrer">sunandstring/marketplace</a></li>
            </ul>

            <h2>Ready to Get Started?</h2>
            <p>Contact us at <a href="mailto:support.sunandstring@ianbunag.dev">support.sunandstring@ianbunag.dev</a> with your company information, and we'll get you set up!</p>
        </main>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>

