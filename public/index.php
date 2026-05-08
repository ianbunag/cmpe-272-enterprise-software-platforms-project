<?php require_once __DIR__ . '/../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Home"); ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', sans-serif; }

            /* ── Hero ── */
            .hero {
                background: #f9f3e7;
                background-image: radial-gradient(circle at 20% 50%, rgba(255,200,100,0.12) 0%, transparent 60%),
                                  radial-gradient(circle at 80% 20%, rgba(255,160,60,0.08) 0%, transparent 50%);
                padding: 7rem 1.5rem 6rem;
                text-align: center;
                position: relative;
                overflow: hidden;
            }
            .hero h1 {
                font-size: 3.2rem;
                font-weight: 800;
                color: #111;
                margin: 0 0 1.25rem;
                line-height: 1.15;
                letter-spacing: -0.03em;
                text-decoration: none !important;
            }
            .hero h1 span {
                color: #c8860a;
                text-decoration: none !important;
            }
            .hero p {
                font-size: 1.1rem;
                color: #777;
                max-width: 520px;
                margin: 0 auto 2.5rem;
                line-height: 1.75;
                font-weight: 400;
            }
            .hero-cta { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }
            .btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.8rem 1.75rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 700;
                font-size: 0.95rem;
                transition: background 0.15s, transform 0.15s;
            }
            .btn-primary:hover { background: #2a2a2a; transform: translateY(-1px); }
            .btn-outline {
                display: inline-flex;
                align-items: center;
                padding: 0.8rem 1.75rem;
                background: #fff;
                color: #111;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.95rem;
                border: 1px solid #ddd;
                transition: border-color 0.15s, transform 0.15s;
            }
            .btn-outline:hover { border-color: #aaa; transform: translateY(-1px); }


            /* ── Shared layout ── */
            .section { padding: 5rem 1.5rem; max-width: 1100px; margin: 0 auto; }
            .section-header { text-align: center; margin-bottom: 3rem; }
            .section-header h2 {
                font-size: 1.9rem;
                font-weight: 800;
                color: #111;
                margin: 0 0 0.5rem;
                letter-spacing: -0.02em;
            }
            .section-header p { font-size: 0.95rem; color: #999; margin: 0; }

            /* ── Feature cards ── */
            .feature-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.25rem;
            }
            .feature-card {
                background: #fff;
                border: 1px solid #ebebeb;
                border-radius: 14px;
                padding: 2rem 1.75rem;
                transition: box-shadow 0.2s, transform 0.2s;
            }
            .feature-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.08); transform: translateY(-3px); }
            .feature-icon {
                width: 48px;
                height: 48px;
                background: #f9f3e7;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.4rem;
                margin-bottom: 1.25rem;
            }
            .feature-card h3 { font-size: 1rem; font-weight: 700; color: #111; margin: 0 0 0.5rem; }
            .feature-card p { font-size: 0.88rem; color: #777; margin: 0; line-height: 1.65; }

            /* ── Trending products ── */
            .product-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 1rem;
            }
            .product-card {
                background: #fff;
                border: 1px solid #ebebeb;
                border-radius: 12px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                transition: box-shadow 0.2s, transform 0.2s;
            }
            .product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1); transform: translateY(-3px); }
            .product-card-img {
                position: relative;
                overflow: hidden;
            }
            .product-card-img img {
                width: 100%;
                height: 130px;
                object-fit: cover;
                display: block;
                transition: transform 0.3s;
            }
            .product-card:hover .product-card-img img { transform: scale(1.05); }
            .product-card-body { padding: 0.85rem; flex: 1; }
            .product-card-body h3 {
                font-size: 0.85rem;
                font-weight: 700;
                color: #111;
                margin: 0 0 0.2rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .product-company {
                font-size: 0.72rem;
                color: #bbb;
                margin: 0 0 0.4rem;
                font-weight: 500;
            }
            .product-price {
                font-size: 0.85rem;
                font-weight: 700;
                color: #c8860a;
                margin: 0;
            }
            .product-card-footer { padding: 0.6rem 0.85rem; border-top: 1px solid #f5f5f5; }
            .product-card-footer a {
                display: block;
                text-align: center;
                padding: 0.4rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 6px;
                font-size: 0.78rem;
                font-weight: 600;
                transition: background 0.15s;
            }
            .product-card-footer a:hover { background: #333; }

            /* ── Testimonials ── */
            .testimonial-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.25rem;
            }
            .testimonial {
                background: #fff;
                border: 1px solid #ebebeb;
                border-radius: 14px;
                padding: 2rem;
                position: relative;
                transition: box-shadow 0.2s;
            }
            .testimonial:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.07); }
            .testimonial-quote {
                font-size: 4rem;
                line-height: 1;
                color: #f0e8d8;
                font-family: Georgia, serif;
                margin: 0 0 0.5rem;
                display: block;
            }
            .testimonial-stars {
                color: #e8a020;
                font-size: 0.85rem;
                margin-bottom: 0.75rem;
                letter-spacing: 0.1em;
            }
            .testimonial blockquote {
                font-size: 0.9rem;
                color: #555;
                line-height: 1.75;
                margin: 0 0 1.25rem;
                font-style: italic;
            }
            .testimonial-author {
                display: flex;
                align-items: center;
                gap: 0.6rem;
            }
            .testimonial-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #f0e8d8;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                font-weight: 700;
                color: #c8860a;
                flex-shrink: 0;
            }
            .testimonial-name { font-size: 0.85rem; font-weight: 700; color: #111; margin: 0; }
            .testimonial-role { font-size: 0.75rem; color: #bbb; margin: 0; }

            /* ── CTA banner ── */
            .cta-section {
                background: #f9f3e7;
                background-image: radial-gradient(ellipse at 50% 120%, rgba(200,134,10,0.15) 0%, transparent 70%);
                padding: 6rem 1.5rem;
                text-align: center;
                position: relative;
                overflow: hidden;
            }
            .cta-section::before {
                content: '';
                position: absolute;
                width: 500px;
                height: 500px;
                border-radius: 50%;
                border: 1px solid rgba(200,134,10,0.12);
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                pointer-events: none;
            }
            .cta-section::after {
                content: '';
                position: absolute;
                width: 750px;
                height: 750px;
                border-radius: 50%;
                border: 1px solid rgba(200,134,10,0.07);
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                pointer-events: none;
            }
            .cta-section h2 {
                font-size: 2.4rem;
                font-weight: 800;
                color: #111;
                margin: 0 0 0.75rem;
                letter-spacing: -0.03em;
                position: relative;
            }
            .cta-section p { color: #888; margin: 0 0 2.25rem; font-size: 1rem; position: relative; }
            .btn-cta {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.9rem 2.25rem;
                background: #111;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 700;
                font-size: 0.95rem;
                transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
                position: relative;
                box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            }
            .btn-cta:hover { background: #2a2a2a; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); }

            @media (max-width: 768px) {
                .hero h1 { font-size: 2rem; }
                .hero { padding: 4rem 1.25rem; }
                .feature-grid, .testimonial-grid, .product-grid { grid-template-columns: 1fr; }
                .stats-inner { gap: 1.5rem; }
                .hero-cta { flex-direction: column; align-items: center; }
            }
            @media (min-width: 769px) and (max-width: 1024px) {
                .feature-grid, .testimonial-grid { grid-template-columns: repeat(2, 1fr); }
                .product-grid { grid-template-columns: repeat(3, 1fr); }
                .hero h1 { font-size: 2.5rem; }
            }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>

        <!-- Hero -->
        <section class="hero">
            <h1>One place for<br><span>everything you love</span></h1>
            <p>Browse travel packages, artisan gear, exotic produce, and more. Curated by trusted sellers, all in one marketplace.</p>
            <div class="hero-cta">
                <a href="/products" class="btn-primary">Browse Products &rarr;</a>
                <?php if (!SessionService::isAuthenticated()) { ?>
                <a href="/login" class="btn-outline">Sign In Free</a>
                <?php } ?>
            </div>
        </section>

        <!-- Features -->
        <div style="background: #fff;">
            <div class="section">
                <div class="section-header">
                    <h2>Why Sun &amp; String?</h2>
                    <p>Everything you need, from sellers you can trust.</p>
                </div>
                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon">&#127760;</div>
                        <h3>Curated Selection</h3>
                        <p>Hand-picked products from verified vendors across multiple specialty companies: travel, gear, produce, and more.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">&#11088;</div>
                        <h3>Verified Reviews</h3>
                        <p>Real ratings from real buyers. Browse honest reviews and ratings before you commit to any purchase.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">&#128200;</div>
                        <h3>Live Trending</h3>
                        <p>See what other shoppers are visiting in real time. Our trending algorithm surfaces the most popular products daily.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trending products -->
        <?php
        $trending = SearchService::searchProducts(
            SearchService::QUERY_NONE,
            SearchService::SORT_TRENDING,
            SearchService::COMPANY_NONE
        );
        $top5 = array_slice($trending, 0, 5);
        if (!empty($top5)):
        ?>
        <div style="background: #f9f3e7;">
            <div class="section">
                <div class="section-header">
                    <h2>Trending Now</h2>
                    <p>The most-visited products across all vendors this week.</p>
                </div>
                <div class="product-grid">
                    <?php foreach ($top5 as $product): ?>
                    <div class="product-card">
                        <div class="product-card-img">
                            <img
                                src="<?= htmlspecialchars($product['imageUrl'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                loading="lazy"
                            >
                        </div>
                        <div class="product-card-body">
                            <h3><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="product-company"><?= htmlspecialchars($product['company_name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="product-price"><?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?></p>
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

        <!-- Testimonials -->
        <div style="background: #fff;">
            <div class="section">
                <div class="section-header">
                    <h2>Loved by Shoppers</h2>
                    <p>Trusted by customers across all our vendor companies.</p>
                </div>
                <div class="testimonial-grid">
                    <div class="testimonial">
                        <span class="testimonial-quote">&ldquo;</span>
                        <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <blockquote>Sun &amp; String made it so easy to find my dream vacation package. Booked the Europe Tour and it was absolutely incredible.</blockquote>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">SM</div>
                            <div>
                                <p class="testimonial-name">Sarah M.</p>
                                <p class="testimonial-role">Verified Buyer</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial">
                        <span class="testimonial-quote">&ldquo;</span>
                        <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <blockquote>I discovered products I couldn't find anywhere else. The vendor variety across the marketplace is completely unmatched.</blockquote>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">JL</div>
                            <div>
                                <p class="testimonial-name">James L.</p>
                                <p class="testimonial-role">Verified Buyer</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial">
                        <span class="testimonial-quote">&ldquo;</span>
                        <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                        <blockquote>The ratings system helped me pick the perfect family vacation package. The whole experience was seamless and fun.</blockquote>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">AK</div>
                            <div>
                                <p class="testimonial-name">Aisha K.</p>
                                <p class="testimonial-role">Verified Buyer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="cta-section">
            <h2>Ready to Explore?</h2>
            <p>Join for free and start discovering curated products from our trusted vendors.</p>
            <a href="/products" class="btn-cta">Get Started &rarr;</a>
        </div>

        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
