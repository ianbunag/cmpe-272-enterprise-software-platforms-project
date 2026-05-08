<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Home"); ?>
        <style>
            .hero {
                background: #111;
                color: #fff;
                padding: 5rem 1.5rem;
                text-align: center;
            }
            .hero h1 {
                font-size: 2.6rem;
                font-weight: 700;
                margin: 0 0 1rem;
                line-height: 1.2;
            }
            .hero p {
                font-size: 1.1rem;
                color: #ccc;
                max-width: 560px;
                margin: 0 auto 2rem;
            }
            .hero a {
                display: inline-block;
                padding: 0.75rem 2rem;
                background: #f9f3e7;
                color: #111;
                text-decoration: none;
                border-radius: 4px;
                font-weight: 700;
                font-size: 1rem;
            }
            .hero a:hover { background: #ede4d0; }
            .section {
                padding: 4rem 1.5rem;
                max-width: 1100px;
                margin: 0 auto;
            }
            .section-title {
                font-size: 1.8rem;
                font-weight: 700;
                text-align: center;
                margin: 0 0 2.5rem;
                color: #111;
            }
            .card-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }
            .card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 2rem 1.5rem;
                text-align: center;
            }
            .card-icon { font-size: 2.2rem; margin-bottom: 1rem; }
            .card h3 { font-size: 1.1rem; font-weight: 700; margin: 0 0 0.5rem; color: #111; }
            .card p { font-size: 0.9rem; color: #666; margin: 0; line-height: 1.5; }
            .product-card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }
            .product-card img {
                width: 100%;
                height: 160px;
                object-fit: cover;
            }
            .product-card-body { padding: 1rem; flex: 1; }
            .product-card-body h3 { font-size: 1rem; font-weight: 700; margin: 0 0 0.25rem; color: #111; }
            .product-card-body .company { font-size: 0.8rem; color: #888; margin: 0 0 0.4rem; }
            .product-card-body .price { font-size: 0.95rem; font-weight: 600; color: #333; margin: 0; }
            .product-card-footer {
                padding: 0.75rem 1rem;
                border-top: 1px solid #eee;
            }
            .product-card-footer a {
                display: block;
                text-align: center;
                padding: 0.4rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                font-size: 0.85rem;
                font-weight: 600;
            }
            .product-card-footer a:hover { background: #333; }
            .testimonial {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 1.5rem;
            }
            .testimonial blockquote {
                font-size: 0.95rem;
                color: #444;
                line-height: 1.6;
                margin: 0 0 1rem;
                font-style: italic;
            }
            .testimonial cite { font-size: 0.85rem; color: #666; font-style: normal; font-weight: 600; }
            .cta-banner {
                background: #f9f3e7;
                border-top: 1px solid #ddd;
                padding: 3rem 1.5rem;
                text-align: center;
            }
            .cta-banner h2 { font-size: 1.6rem; font-weight: 700; margin: 0 0 1rem; color: #111; }
            .cta-banner p { color: #666; margin: 0 0 1.5rem; }
            .cta-banner a {
                display: inline-block;
                padding: 0.75rem 2rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 4px;
                font-weight: 700;
            }
            .cta-banner a:hover { background: #333; }
            @media (max-width: 768px) {
                .hero h1 { font-size: 1.8rem; }
                .card-grid { grid-template-columns: 1fr; }
            }
            @media (min-width: 769px) and (max-width: 1024px) {
                .card-grid { grid-template-columns: repeat(2, 1fr); }
            }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>

        <section class="hero">
            <h1>Discover Products from Top Vendors</h1>
            <p>Browse travel packages, artisan gear, exotic produce, and more &mdash; all curated by trusted sellers in one place.</p>
            <a href="/products">Browse Products &rarr;</a>
        </section>

        <div class="section">
            <h2 class="section-title">Why Sun &amp; String?</h2>
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">&#127760;</div>
                    <h3>Curated Selection</h3>
                    <p>Every product is hand-picked from verified vendors across multiple specialty companies.</p>
                </div>
                <div class="card">
                    <div class="card-icon">&#11088;</div>
                    <h3>Trusted Reviews</h3>
                    <p>Real ratings and reviews from verified buyers help you shop with confidence.</p>
                </div>
                <div class="card">
                    <div class="card-icon">&#127881;</div>
                    <h3>One Marketplace</h3>
                    <p>Shop from multiple specialty companies &mdash; travel, gear, produce &mdash; all in a single place.</p>
                </div>
            </div>
        </div>

        <?php
        $trendingProducts = SearchService::searchProducts(
            SearchService::QUERY_NONE,
            SearchService::SORT_TRENDING,
            SearchService::COMPANY_NONE
        );
        $top5 = array_slice($trendingProducts, 0, 5);
        if (!empty($top5)):
        ?>
        <div style="background: #fff; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
            <div class="section">
                <h2 class="section-title">Trending Products</h2>
                <div class="card-grid" style="grid-template-columns: repeat(5, 1fr);">
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
                                <a href="/login?returnTo=/products/<?= htmlspecialchars($product['product_id'], ENT_QUOTES, 'UTF-8') ?>">Login to View &rarr;</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div <?= empty($top5) ? 'style="background: #fff; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;"' : '' ?>>
            <div class="section">
                <h2 class="section-title">What Our Customers Say</h2>
                <div class="card-grid">
                    <div class="testimonial">
                        <blockquote>"Sun &amp; String made it so easy to find my dream vacation package. I booked the Europe Tour and it was absolutely incredible."</blockquote>
                        <cite>— Sarah M.</cite>
                    </div>
                    <div class="testimonial">
                        <blockquote>"I discovered the most unique products I couldn't find anywhere else. The vendor variety is unmatched."</blockquote>
                        <cite>— James L.</cite>
                    </div>
                    <div class="testimonial">
                        <blockquote>"The ratings system helped me pick the perfect family vacation package. Couldn't be happier with the experience."</blockquote>
                        <cite>— Aisha K.</cite>
                    </div>
                </div>
            </div>
        </div>

        <div class="cta-banner">
            <h2>Ready to Explore?</h2>
            <p>Create an account and start discovering curated products from our trusted vendors.</p>
            <a href="/products">Get Started &rarr;</a>
        </div>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
