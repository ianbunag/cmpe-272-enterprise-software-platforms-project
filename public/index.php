<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Home"); ?>
        <style>
            .hero {
                background: #f9f3e7;
                border-bottom: 1px solid #ddd;
                padding: 6rem 1.5rem;
                text-align: center;
            }
            .hero h1 {
                font-size: 2.8rem;
                font-weight: 700;
                color: #111;
                margin: 0 0 1rem;
                line-height: 1.2;
            }
            .hero p {
                font-size: 1.1rem;
                color: #666;
                max-width: 540px;
                margin: 0 auto 2rem;
                line-height: 1.7;
            }
            .btn-primary {
                display: inline-block;
                padding: 0.75rem 2rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                font-weight: 700;
                font-size: 1rem;
                transition: background 0.15s;
            }
            .btn-primary:hover { background: #333; }
            .section {
                padding: 4rem 1.5rem;
                max-width: 1100px;
                margin: 0 auto;
            }
            .section-title {
                font-size: 1.6rem;
                font-weight: 700;
                text-align: center;
                color: #111;
                margin: 0 0 0.5rem;
            }
            .section-subtitle {
                text-align: center;
                color: #888;
                font-size: 0.95rem;
                margin: 0 0 2.5rem;
            }
            .card-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }
            .feature-card {
                background: #fff;
                border: 1px solid #e5e5e5;
                border-radius: 10px;
                padding: 2rem 1.5rem;
                text-align: center;
            }
            .feature-card .icon {
                font-size: 2rem;
                margin-bottom: 0.75rem;
            }
            .feature-card h3 {
                font-size: 1rem;
                font-weight: 700;
                color: #111;
                margin: 0 0 0.5rem;
            }
            .feature-card p {
                font-size: 0.88rem;
                color: #666;
                margin: 0;
                line-height: 1.6;
            }
            .product-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 1rem;
            }
            .product-card {
                background: #fff;
                border: 1px solid #e5e5e5;
                border-radius: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }
            .product-card img {
                width: 100%;
                height: 130px;
                object-fit: cover;
            }
            .product-card-body {
                padding: 0.75rem;
                flex: 1;
            }
            .product-card-body h3 {
                font-size: 0.88rem;
                font-weight: 700;
                color: #111;
                margin: 0 0 0.2rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .product-card-body .company {
                font-size: 0.75rem;
                color: #999;
                margin: 0 0 0.3rem;
            }
            .product-card-body .price {
                font-size: 0.85rem;
                font-weight: 600;
                color: #333;
                margin: 0;
            }
            .product-card-footer {
                padding: 0.6rem 0.75rem;
                border-top: 1px solid #f0f0f0;
            }
            .product-card-footer a {
                display: block;
                text-align: center;
                padding: 0.35rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                font-size: 0.8rem;
                font-weight: 600;
            }
            .product-card-footer a:hover { background: #333; }
            .testimonial {
                background: #fff;
                border: 1px solid #e5e5e5;
                border-radius: 10px;
                padding: 1.75rem;
            }
            .testimonial blockquote {
                font-size: 0.9rem;
                color: #555;
                line-height: 1.7;
                margin: 0 0 1rem;
                font-style: italic;
            }
            .testimonial cite {
                font-size: 0.82rem;
                color: #999;
                font-style: normal;
                font-weight: 600;
            }
            .cta-section {
                background: #111;
                padding: 4rem 1.5rem;
                text-align: center;
            }
            .cta-section h2 {
                font-size: 1.8rem;
                font-weight: 700;
                color: #fff;
                margin: 0 0 0.75rem;
            }
            .cta-section p {
                color: #aaa;
                margin: 0 0 2rem;
            }
            .btn-secondary {
                display: inline-block;
                padding: 0.75rem 2rem;
                background: #f9f3e7;
                color: #111;
                text-decoration: none;
                border-radius: 4px;
                font-weight: 700;
            }
            .btn-secondary:hover { background: #ede4d0; }
            @media (max-width: 768px) {
                .hero h1 { font-size: 1.9rem; }
                .hero { padding: 4rem 1.25rem; }
                .card-grid, .product-grid { grid-template-columns: 1fr; }
            }
            @media (min-width: 769px) and (max-width: 1024px) {
                .card-grid { grid-template-columns: repeat(2, 1fr); }
                .product-grid { grid-template-columns: repeat(3, 1fr); }
            }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>

        <section class="hero">
            <h1>Discover Products from<br>Top Vendors</h1>
            <p>Browse travel packages, artisan gear, exotic produce, and more &mdash; curated by trusted sellers in one marketplace.</p>
            <a href="/products" class="btn-primary">Browse Products &rarr;</a>
        </section>

        <div style="background: #fff; border-bottom: 1px solid #ddd;">
            <div class="section">
                <h2 class="section-title">Why Sun &amp; String?</h2>
                <p class="section-subtitle">Everything you need, from sellers you can trust.</p>
                <div class="card-grid">
                    <div class="feature-card">
                        <div class="icon">&#127760;</div>
                        <h3>Curated Selection</h3>
                        <p>Hand-picked products from verified vendors across multiple specialty companies.</p>
                    </div>
                    <div class="feature-card">
                        <div class="icon">&#11088;</div>
                        <h3>Verified Reviews</h3>
                        <p>Real ratings from real buyers so you can shop with confidence every time.</p>
                    </div>
                    <div class="feature-card">
                        <div class="icon">&#127381;</div>
                        <h3>One Marketplace</h3>
                        <p>Travel, gear, produce &mdash; multiple specialty companies, all in one place.</p>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $trending = SearchService::searchProducts(
            SearchService::QUERY_NONE,
            SearchService::SORT_TRENDING,
            SearchService::COMPANY_NONE
        );
        $top5 = array_slice($trending, 0, 5);
        if (!empty($top5)):
        ?>
        <div style="background: #f9f3e7; border-bottom: 1px solid #ddd;">
            <div class="section">
                <h2 class="section-title">Trending Now</h2>
                <p class="section-subtitle">The most-visited products across the marketplace.</p>
                <div class="product-grid">
                    <?php foreach ($top5 as $product): ?>
                    <div class="product-card">
                        <img
                            src="<?= htmlspecialchars($product['imageUrl'], ENT_QUOTES, 'UTF-8') ?>"
                            alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                            loading="lazy"
                        >
                        <div class="product-card-body">
                            <h3><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="company"><?= htmlspecialchars($product['company_name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="price"><?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <div class="product-card-footer">
                            <?php if (SessionService::isAuthenticated()): ?>
                                <a href="/products/<?= htmlspecialchars($product['product_id'], ENT_QUOTES, 'UTF-8') ?>">View &rarr;</a>
                            <?php else: ?>
                                <a href="/login?returnTo=/products/<?= htmlspecialchars($product['product_id'], ENT_QUOTES, 'UTF-8') ?>">Login to View</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div style="background: #fff; border-bottom: 1px solid #ddd;">
            <div class="section">
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-subtitle">Trusted by shoppers across all our vendor companies.</p>
                <div class="card-grid">
                    <div class="testimonial">
                        <blockquote>"Sun &amp; String made it so easy to find my dream vacation package. Booked the Europe Tour and it was absolutely incredible."</blockquote>
                        <cite>— Sarah M.</cite>
                    </div>
                    <div class="testimonial">
                        <blockquote>"I discovered products I couldn't find anywhere else. The vendor variety across the marketplace is unmatched."</blockquote>
                        <cite>— James L.</cite>
                    </div>
                    <div class="testimonial">
                        <blockquote>"The ratings system helped me pick the perfect family vacation package. Couldn't be happier."</blockquote>
                        <cite>— Aisha K.</cite>
                    </div>
                </div>
            </div>
        </div>

        <div class="cta-section">
            <h2>Ready to Explore?</h2>
            <p>Create an account and start discovering curated products from our trusted vendors.</p>
            <a href="/products" class="btn-secondary">Get Started &rarr;</a>
        </div>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
