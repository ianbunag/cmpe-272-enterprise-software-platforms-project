# Contributing Guide

*Estimated read time: 2 minutes*

## Directory Overview

The codebase is organized into functional directories:

- **`/src`** - Reusable PHP services and shared components
- **`/public`** - Web-accessible entry points and static assets
- **`/migrations`** - Database schema migrations using Phinx
- **`/nginx`** - Nginx web server configuration and routing rules
- **`/php-fpm`** - PHP runtime configuration

The application runs on MariaDB (containerized) and is orchestrated via Docker Compose.

## Creating and Using Reusable Components

Place reusable PHP classes and utilities in the `/src` directory. Each class should have a single responsibility.

When creating a reusable component, follow the pattern of existing services like `LayoutService` and `VersionService` (see `/src`). Initialize required dependencies in the component itself and expose static or instance methods as appropriate.

Simulate autoloading by including any new component in `/src/index.php`, which is required by all entry point files in `/public`. This ensures that your component is available globally without needing to manually include it in every file.

## Adding Pages: Static and Dynamic Routing

Static pages are created as PHP files directly in `/public` or in subdirectories. For example, `/public/page-name.php` becomes accessible at `/page-name`, and `/public/subdir/index.php` becomes accessible at `/subdir/`.

Dynamic pages with URL parameters are routed through the Nginx configuration in `/nginx/default.conf`. The routing system uses Nginx `map` directives to:

1. Parse the incoming URL with a regex pattern
2. Extract route parameters from the URL
3. Rewrite the request to a target PHP file with parameters passed as query strings

Look at the existing products route (`/products/[id]`) in `/nginx/default.conf` to see the pattern. Create new dynamic routes by adding corresponding `map` blocks and ensuring the target PHP file exists in `/public`.

Pages should include the shared layout by requiring `/src/index.php`, which loads common services.

## Database and Migrations

Database migrations are stored in `/migrations` and managed by Phinx (see `phinx.php`). To create a migration, use Phinx to generate a new migration file in the `/migrations` directory.

All database interactions must use PDO. Connection details are passed via environment variables (DB_HOST, DB_NAME, DB_USER, DB_PASSWORD). Obtain a PDO connection through the environment and execute queries directly.

Refer to existing migrations in `/migrations` for the structure and pattern. Before adding features that require database tables, create and run migrations through the Phinx CLI.

## Frontend and Styling

The application uses **Matcha CSS** (https://matcha.mizu.sh/matcha.css), a minimal CSS framework. This framework is included in all pages via the `LayoutService::renderHeaders()` method (see `/src/LayoutService.php`). When creating new pages or components, use semantic HTML and Matcha CSS classes for styling. The framework provides utility classes for layout, typography, forms, buttons, and more.

For custom components or layouts not covered by Matcha CSS (such as navigation bars), use inline styles in the HTML elements. Keep styles concise and focused on layout and spacing. External CSS files should only be used for global styles in `/static/index.css`.

## Development Environment

The application is containerized with Docker Compose. Services include:

- **mariadb** - Database server
- **nginx** - Web server with routing
- **php-fpm** - PHP application runtime
- **vendor** - Dependency directory managed by Composer

The Docker Compose setup is not intended for further development or modification—focus on application code changes instead. Environment variables are read from `.env` (create from `.env.example` if needed).

To run the application locally, use Docker Compose commands to start the services. Nginx proxies requests to PHP-FPM, which executes your PHP files.

# Getting Started with This Codebase

## Adding Your Company to the Marketplace

To list your products in the marketplace, follow these steps:

### 1. Add Your Company to the Database

Insert a row into the `company` table with the following fields:
- `id`: Unique integer ID for your company (auto-generated)
- `name`: Your company name
- `productsApiUrl`: The public URL to your product API endpoint (see below)
- `enabled`: Set to `1` to make your company visible in the marketplace

**Example SQL:**
```sql
INSERT INTO company (name, productsApiUrl, enabled)
VALUES ('Acme Travel', 'https://yourdomain.com/products', 1);
```

### 2. Expose a Product API Endpoint

Your website must provide a public HTTP endpoint that returns your product list in the format defined by the marketplace OpenAPI spec. The endpoint URL you provide in `productsApiUrl` will be called by the marketplace to fetch your products.

- The endpoint must be accessible via HTTPS.
- The endpoint must respond to a `GET` request with a JSON array of products.
- Each product must match the schema in [open-api-spec.yaml](./open-api-spec.yaml).

### 3. Match the OpenAPI Specification

The required API contract is defined in [open-api-spec.yaml](./open-api-spec.yaml). To view and validate your API, view the contents of [open-api-spec.yaml](./open-api-spec.yaml) in your preferred IDE or copy it into [Swagger Editor](https://editor.swagger.io).

### 4. Example Endpoint

You can see a working example at:

    https://your-marketplace-domain/api/test/products
