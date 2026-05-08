<?php
require_once __DIR__ . '/../../src/index.php';

LayoutService::requireAuthenticated();

$query = isset($_GET['q']) && $_GET['q'] !== '' ? trim($_GET['q']) : null;
$sort = $_GET['sort'] ?? SearchService::SORT_NAME;
$companyId = isset($_GET['company']) && $_GET['company'] !== '' && is_numeric($_GET['company']) ? (int)$_GET['company'] : SearchService::COMPANY_NONE;

if (!in_array($sort, [SearchService::SORT_NAME, SearchService::SORT_TRENDING, SearchService::SORT_TOP_RATED])) {
    $sort = SearchService::SORT_NAME;
}

$companies = SearchService::getCompanies();
$products = SearchService::searchProducts($query, $sort, $companyId);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Products"); ?>
        <style>
            #product-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }
            #product-grid article {
                transition: transform 0.15s ease, box-shadow 0.15s ease;
            }
            #product-grid article:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            }
            @media (max-width: 900px) {
                #product-grid { grid-template-columns: repeat(2, 1fr); }
            }
            @media (max-width: 560px) {
                #product-grid { grid-template-columns: 1fr; }
                #filters-bar { flex-direction: column; }
            }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        <main style="max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem;">
            <h1 style="margin-bottom: 1.5rem; color: #111;">Products</h1>

            <form method="get" action="/products" id="filters-bar" style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="q" style="display: block; font-size: 0.85rem; margin-bottom: 0.3rem; font-weight: 500;">Search</label>
                    <div style="display: flex;">
                        <input type="search" id="q" name="q" value="<?= htmlspecialchars($query ?? '') ?>" placeholder="Search products..." style="flex: 1; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <button type="submit" aria-label="Search" style="padding: 0.4rem 0.8rem; border-top-left-radius: 0; border-bottom-left-radius: 0; cursor: pointer;">🔍</button>
                    </div>
                </div>

                <div style="min-width: 150px;">
                    <label for="sort" style="display: block; font-size: 0.85rem; margin-bottom: 0.3rem; font-weight: 500;">Sort by</label>
                    <select id="sort" name="sort" onchange="this.form.submit()" style="width: 100%;">
                        <option value="<?= SearchService::SORT_NAME ?>" <?= $sort === SearchService::SORT_NAME ? 'selected' : '' ?>>Name</option>
                        <option value="<?= SearchService::SORT_TRENDING ?>" <?= $sort === SearchService::SORT_TRENDING ? 'selected' : '' ?>>Trending</option>
                        <option value="<?= SearchService::SORT_TOP_RATED ?>" <?= $sort === SearchService::SORT_TOP_RATED ? 'selected' : '' ?>>Top Rated</option>
                    </select>
                </div>

                <div style="min-width: 150px;">
                    <label for="company" style="display: block; font-size: 0.85rem; margin-bottom: 0.3rem; font-weight: 500;">Shop</label>
                    <select id="company" name="company" onchange="this.form.submit()" style="width: 100%;">
                        <option value="">All</option>
                        <?php foreach ($companies as $c): ?>
                            <option value="<?= htmlspecialchars((string)$c['id']) ?>" <?= $companyId === $c['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>

            <?php if (empty($products)): ?>
                <p style="color: #555; text-align: center; padding: 3rem 0;">No products found.</p>
            <?php else: ?>
                <div id="product-grid">
                    <?php foreach ($products as $product): ?>
                        <?php
                        $avg = (float)$product['rating_average'];
                        $count = (int)$product['rating_count'];
                        $rounded = max(0, min(5, (int)round($avg)));
                        $productUrl = '/products/' . htmlspecialchars($product['product_id']);
                        ?>
                        <article style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                            <a href="<?= $productUrl ?>" style="display: block; overflow: hidden; line-height: 0; flex-shrink: 0;">
                                <img src="<?= htmlspecialchars($product['imageUrl']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy" style="width: 100%; height: 200px; object-fit: cover;">
                            </a>
                            <div style="padding: 1rem; flex: 1; display: flex; flex-direction: column; gap: 0.35rem;">
                                <h3 style="margin: 0; font-size: 1rem; line-height: 1.3;">
                                    <a href="<?= $productUrl ?>" style="text-decoration: none; color: #111;"><?= htmlspecialchars($product['name']) ?></a>
                                </h3>
                                <p style="margin: 0; font-weight: 600; color: #333;"><?= htmlspecialchars($product['price']) ?></p>
                                <p style="margin: 0; font-size: 0.82rem; color: #555;"><?= htmlspecialchars($product['company_name']) ?></p>
                                <div style="display: flex; align-items: center; gap: 0.4rem; margin-top: auto; padding-top: 0.5rem;">
                                    <span style="color: #f5a623; letter-spacing: 1px;" aria-hidden="true">
                                        <?= str_repeat('★', $rounded) . str_repeat('☆', 5 - $rounded) ?>
                                    </span>
                                    <span style="font-size: 0.8rem; color: #555;">
                                        <?= $count > 0 ? number_format($count) . ' rating' . ($count !== 1 ? 's' : '') : 'No ratings yet' ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
