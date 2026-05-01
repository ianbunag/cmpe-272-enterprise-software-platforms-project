<?php require_once __DIR__ . '/../../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("products"); ?>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        <?php
            $products = SearchService::getRawProducts("http://nginx:80/api/test/products?company=1");
            echo json_encode($products, JSON_PRETTY_PRINT);
        ?>
    </body>
</html>
