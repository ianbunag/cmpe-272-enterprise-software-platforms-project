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
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders($product['name']) ?>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        <?php
            // @TODO start of example service usage, remove later.
            function renderReview(array $review) {
                echo 'product_id: ' . htmlspecialchars((string)$review['product_id']) . '<br>';
                echo 'user_id: ' . htmlspecialchars((string)$review['user_id']) . '<br>';
                echo 'user_display_name: ' . htmlspecialchars((string)$review['user_display_name']) . '<br>';
                echo 'rating: ' . htmlspecialchars((string)$review['rating']) . '<br>';
                echo 'comment: ' . htmlspecialchars($review['comment']) . '<br>';
                echo 'created_on: ' . htmlspecialchars($review['created_on']) . '<br>';
                echo '<hr>';
            }

            echo "<h2>Product</h2>";
            echo 'product_id: ' . htmlspecialchars($product['product_id']) . '<br>';
            echo 'name: ' . htmlspecialchars($product['name']) . '<br>';
            echo 'company_name: ' . htmlspecialchars($product['company_name']) . '<br>';
            echo 'price: ' . htmlspecialchars($product['price']) . '<br>';
            echo 'description: ' . htmlspecialchars($product['description']) . '<br>';
            echo 'imageUrl: <a href="' . htmlspecialchars($product['imageUrl']) . '">' . htmlspecialchars($product['imageUrl']) . '</a><br>';
            echo 'websiteUrl: <a href="' . htmlspecialchars($product['websiteUrl']) . '">' . htmlspecialchars($product['websiteUrl']) . '</a><br>';
            echo 'rating_average: ' . htmlspecialchars((string)$product['rating_average']) . '<br>';
            echo 'rating_count: ' . htmlspecialchars((string)$product['rating_count']) . '<br>';
            echo '<hr>';

            $existingReviewUserIds = [];
            $currentUserReview = RatingService::getCurrentUserReview($product['product_id'], UserService::getId());
            if ($currentUserReview) {
                echo "<h2>Current user review</h2>";
                renderReview($currentUserReview);
                $existingReviewUserIds[] = $currentUserReview['user_id'];
            } else {
                echo "<h2>No current user review</h2>";
                echo "<hr>";
            }

            $bestUserReview = RatingService::getBestUserReview($product['product_id'], $existingReviewUserIds);
            if ($bestUserReview) {
                echo "<h2>Best user review</h2>";
                renderReview($bestUserReview);
                $existingReviewUserIds[] = $bestUserReview['user_id'];
            } else {
                echo "<h2>No best user review</h2>";
                echo "<hr>";
            }

            $worstUserReview = RatingService::getWorstUserReview($product['product_id'], $existingReviewUserIds);
            if ($worstUserReview) {
                echo "<h2>Worst user review</h2>";
                renderReview($worstUserReview);
                $existingReviewUserIds[] = $worstUserReview['user_id'];
            } else {
                echo "<h2>No worst user review</h2>";
                echo "<hr>";
            }

//            RatingService::submitReview(
//                $product['product_id'],
//                UserService::getId(),
//                UserService::getDisplayName(),
//                5,
//                "I really love how sturdy this desk feels because it does not wobble at all when I type. The assembly was very quick and I would definitely recommend it to anyone who needs a solid workspace."
//            );
            // @TODO end of example service usage, remove later.
        ?>
    </body>
</html>

<?php TrackingService::trackVisit($product["product_id"], UserService::getId()); ?>