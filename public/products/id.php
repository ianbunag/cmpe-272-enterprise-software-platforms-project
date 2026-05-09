<?php
require_once __DIR__ . '/../../src/index.php';

LayoutService::requireAuthenticated();

$product = null;
if (isset($_GET['id'])) {
    $product = SearchService::getProduct($_GET['id']);
}

if (!$product) {
    http_response_code(404);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        RatingService::submitReview(
            $product['product_id'],
            UserService::getId(),
            UserService::getDisplayName(),
            $rating,
            $comment
        );
    }
    header('Location: /products/' . urlencode($product['product_id']));
    exit();
}

$existingReviewUserIds = [];
$currentUserReview = RatingService::getCurrentUserReview($product['product_id'], UserService::getId());
if ($currentUserReview) {
    $existingReviewUserIds[] = $currentUserReview['user_id'];
}

$bestUserReview = RatingService::getBestUserReview($product['product_id'], $existingReviewUserIds);
if ($bestUserReview) {
    $existingReviewUserIds[] = $bestUserReview['user_id'];
}

$worstUserReview = RatingService::getWorstUserReview($product['product_id'], $existingReviewUserIds);

$avg = (float)$product['rating_average'];
$count = (int)$product['rating_count'];
$rounded = max(0, min(5, (int)round($avg)));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders($product['name']) ?>
        <style>
            #product-detail {
                display: flex;
                gap: 2rem;
                margin-bottom: 3rem;
            }
            #product-image-col {
                flex: 0 0 340px;
                max-width: 100%;
            }
            @media (max-width: 680px) {
                #product-detail { flex-direction: column; }
                #product-image-col { flex: 0 0 auto; }
            }
        </style>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        <main style="max-width: 960px; margin: 0 auto; padding: 2rem 1.5rem;">

            <nav aria-label="breadcrumb" style="margin-bottom: 1.5rem; font-size: 0.9rem; color: #666;">
                <a href="/products" style="color: #007bff; text-decoration: none;">Products</a>
                <span style="margin: 0 0.5rem; color: #aaa;">›</span>
                <span><?= htmlspecialchars($product['name']) ?></span>
            </nav>

            <section id="product-detail">
                <div id="product-image-col">
                    <img src="<?= htmlspecialchars($product['imageUrl']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; border-radius: 8px; object-fit: cover; aspect-ratio: 4/3;">
                </div>

                <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <h1 style="margin: 0; font-size: 1.6rem; line-height: 1.3; color: #111;"><?= htmlspecialchars($product['name']) ?></h1>
                    <p style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #333;"><?= htmlspecialchars($product['price']) ?></p>
                    <p style="margin: 0; font-size: 0.9rem; color: #666;">Sold by <strong><?= htmlspecialchars($product['company_name']) ?></strong></p>

                    <p style="margin: 0; color: #444; line-height: 1.65;"><?= htmlspecialchars($product['description']) ?></p>

                    <div style="margin-top: 0.5rem;">
                        <a href="<?= htmlspecialchars($product['websiteUrl']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-block; padding: 0.55rem 1.25rem; background-color: #111; color: #fff; text-decoration: none; border-radius: 4px; font-weight: 500; font-size: 0.95rem;">
                            View on <?= htmlspecialchars($product['company_name']) ?> →
                        </a>
                    </div>
                </div>
            </section>

            <section>
                <div style="display: flex; align-items: baseline; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <h2 style="margin: 0; color: #111;">Reviews</h2>
                    <?php if ($count > 0): ?>
                        <span style="display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
                            <span style="color: #f5a623; font-size: 1.1rem; letter-spacing: 1px;" aria-hidden="true"><?= str_repeat('★', $rounded) . str_repeat('☆', 5 - $rounded) ?></span>
                            <span style="font-size: 0.9rem; color: #666;"><?= number_format($avg, 1) ?> out of 5 (<?= number_format($count) ?> customer rating<?= $count !== 1 ? 's' : '' ?>)</span>
                        </span>
                    <?php else: ?>
                        <span style="font-size: 0.9rem; color: #888;">No ratings yet</span>
                    <?php endif; ?>
                </div>

                <?php if (!$currentUserReview): ?>
                    <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem;">
                        <form method="post" action="/products/<?= htmlspecialchars($product['product_id']) ?>" onsubmit="return validateReview()">
                            <input type="hidden" name="rating" id="rating-value">
                            <div style="margin-bottom: 1rem;">
                                <div id="star-picker" role="group" aria-label="Select a rating" style="display: flex; gap: 0.25rem; font-size: 2rem; cursor: pointer; width: fit-content;">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span data-val="<?= $i ?>" style="color: #ccc; line-height: 1; user-select: none;">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div style="margin-bottom: 1.25rem;">
                                <textarea id="comment" name="comment" rows="4" required maxlength="4096" placeholder="Add your review..." style="width: 100%; box-sizing: border-box; resize: vertical;"></textarea>
                            </div>
                            <button type="submit" style="padding: 0.5rem 1.5rem; background-color: #f5c842; color: #111; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.95rem;">Submit</button>
                        </form>
                        <script>
                            (function () {
                                var stars = document.querySelectorAll('#star-picker span');
                                var selected = 0;

                                function paint(n) {
                                    stars.forEach(function (s, i) {
                                        s.style.color = i < n ? '#f5a623' : '#ccc';
                                    });
                                }

                                stars.forEach(function (s) {
                                    s.addEventListener('mouseover', function () { paint(+s.dataset.val); });
                                    s.addEventListener('mouseout',  function () { paint(selected); });
                                    s.addEventListener('click',     function () {
                                        selected = +s.dataset.val;
                                        document.getElementById('rating-value').value = selected;
                                        paint(selected);
                                    });
                                });

                                window.validateReview = function () {
                                    if (!selected) {
                                        alert('Please select a star rating.');
                                        return false;
                                    }
                                    return true;
                                };
                            })();
                        </script>
                    </div>
                <?php endif; ?>

                <?php
                $labeled = [
                    ['label' => 'Your Review',      'review' => $currentUserReview],
                    ['label' => 'Top Review',        'review' => $bestUserReview],
                    ['label' => 'Critical Review',   'review' => $worstUserReview],
                ];
                $hasAnyReview = array_filter($labeled, fn($e) => $e['review'] !== null);
                ?>

                <?php if (empty($hasAnyReview)): ?>
                    <p style="color: #888; text-align: center; padding: 2rem 0;">No reviews yet. Be the first to review!</p>
                <?php else: ?>
                    <?php foreach ($labeled as $entry):
                        if (!$entry['review']) continue;
                        $r = $entry['review'];
                        $rRounded = max(0, min(5, (int)round((float)$r['rating'])));
                        if ($rRounded <= 2) {
                            $cardBg = '#fff0f0'; $cardBorder = '#f5c6c6';
                        } elseif ($rRounded === 3) {
                            $cardBg = '#fffbea'; $cardBorder = '#f0e08a';
                        } else {
                            $cardBg = '#f0fdf4'; $cardBorder = '#a8e6b8';
                        }
                    ?>
                        <article style="background: <?= $cardBg ?>; border: 1px solid <?= $cardBorder ?>; border-radius: 8px; padding: 1.25rem; margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.6rem;">
                                <div>
                                    <span style="font-weight: 600; color: #111;"><?= htmlspecialchars($r['user_display_name']) ?></span>
                                    <span style="font-size: 0.8rem; color: #555; margin-left: 0.5rem; background: #f0f0f0; padding: 0.1rem 0.4rem; border-radius: 3px;"><?= htmlspecialchars($entry['label']) ?></span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.4rem;">
                                    <span style="color: #f5a623; letter-spacing: 1px;" aria-hidden="true"><?= str_repeat('★', $rRounded) . str_repeat('☆', 5 - $rRounded) ?></span>
                                    <span style="font-size: 0.85rem; color: #555;"><?= htmlspecialchars((string)$r['rating']) ?>/5</span>
                                </div>
                            </div>
                            <p style="margin: 0 0 0.6rem; color: #111; line-height: 1.6;"><?= htmlspecialchars($r['comment']) ?></p>
                            <time style="font-size: 0.8rem; color: #777;" datetime="<?= htmlspecialchars($r['created_on']) ?>"><?= htmlspecialchars($r['created_on']) ?></time>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>
        <?php LayoutService::renderFooter(); ?>
    </body>
</html>

<?php TrackingService::trackVisit($product["product_id"], UserService::getId()); ?>
