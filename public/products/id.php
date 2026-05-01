<?php
require_once __DIR__ . '/../../src/index.php';

LayoutService::requiredAuthenticated();

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
            echo 'product_id: ' . htmlspecialchars($product['product_id']) . '<br>';
            echo 'name: ' . htmlspecialchars($product['name']) . '<br>';
            echo 'company_name: ' . htmlspecialchars($product['company_name']) . '<br>';
            echo 'price: ' . htmlspecialchars($product['price']) . '<br>';
            echo 'description: ' . htmlspecialchars($product['description']) . '<br>';
            echo 'imageUrl: <a href="' . htmlspecialchars($product['imageUrl']) . '">' . htmlspecialchars($product['imageUrl']) . '</a><br>';
            echo 'websiteUrl: <a href="' . htmlspecialchars($product['websiteUrl']) . '">' . htmlspecialchars($product['websiteUrl']) . '</a><br>';
            echo 'rating_average: ' . htmlspecialchars((string)$product['rating_average']) . '<br>';
            echo 'rating_count: ' . htmlspecialchars((string)$product['rating_count']) . '<br>';
        ?>
    </body>
</html>

<?php TrackingService::trackVisit($product["product_id"], UserService::getId()); ?>