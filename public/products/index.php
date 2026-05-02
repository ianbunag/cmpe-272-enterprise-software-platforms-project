<?php
require_once __DIR__ . '/../../src/index.php';

LayoutService::requireAuthenticated();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Products"); ?>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        <?php
        // @TODO start of example service usage, remove later.
        function renderCompanies(array $entities) {
            foreach ($entities as $entity) {
                echo 'id: ' . htmlspecialchars((string)$entity['id']) . '<br>';
                echo 'name: ' . htmlspecialchars($entity['name']) . '<br>';
                echo 'productsApiUrl: <a href="' . htmlspecialchars($entity['productsApiUrl']) . '">' . htmlspecialchars($entity['productsApiUrl']) . '</a><br>';
                echo '<hr>';
            }
        }

        function renderProducts(array $entities) {
            foreach ($entities as $entity) {
                echo 'product_id: ' . htmlspecialchars($entity['product_id']) . '<br>';
                echo 'product page: <a href="/products/' . htmlspecialchars($entity['product_id']) . '">/products/' . htmlspecialchars($entity['product_id']) . '</a><br>';
                echo 'name: ' . htmlspecialchars($entity['name']) . '<br>';
                echo 'company_name: ' . htmlspecialchars($entity['company_name']) . '<br>';
                echo 'price: ' . htmlspecialchars($entity['price']) . '<br>';
                echo 'description: ' . htmlspecialchars($entity['description']) . '<br>';
                echo 'imageUrl: <a href="' . htmlspecialchars($entity['imageUrl']) . '">' . htmlspecialchars($entity['imageUrl']) . '</a><br>';
                echo 'websiteUrl: <a href="' . htmlspecialchars($entity['websiteUrl']) . '">' . htmlspecialchars($entity['websiteUrl']) . '</a><br>';
                if (isset($entity['visit_count'])) echo 'visit_count: ' . htmlspecialchars((string)$entity['visit_count']) . '<br>';
                if (isset($entity['rating_average'])) echo 'rating_average: ' . htmlspecialchars((string)$entity['rating_average']) . '<br>';
                if (isset($entity['rating_count'])) echo 'rating_count: ' . htmlspecialchars((string)$entity['rating_count']) . '<br>';
                echo '<hr>';
            }
        }

        $companies = SearchService::getCompanies();

        echo "<h2>Companies</h2>";
        renderCompanies($companies);

        echo "<h2>Products (\$query = SearchService::QUERY_NONE, \$sort = SearchService::SORT_NAME, \$company = SearchService::COMPANY_NONE)</h2>";
        renderProducts(SearchService::searchProducts(SearchService::QUERY_NONE, SearchService::SORT_NAME, SearchService::COMPANY_NONE));

        echo "<h2>Products (\$query = SearchService::QUERY_NONE, \$sort = SearchService::SORT_NAME, \$company = \"" . $companies[0]['name'] . "\")</h2>";
        renderProducts(SearchService::searchProducts(SearchService::QUERY_NONE, SearchService::SORT_NAME, $companies[0]['id']));

        echo "<h2>Products (\$query = \"with\", \$sort = SearchService::SORT_NAME, \$company = \"" . $companies[0]['name'] . "\")</h2>";
        renderProducts(SearchService::searchProducts("with", SearchService::SORT_NAME, $companies[0]['id']));

        echo "<h2>Products (\$query = \"with\", \$sort = SearchService::SORT_TRENDING, \$company = \"" . $companies[0]['name'] . "\")</h2>";
        renderProducts(SearchService::searchProducts("with", SearchService::SORT_TRENDING, $companies[0]['id']));

        echo "<h2>Products (\$query = \"with\", \$sort = SearchService::SORT_TOP_RATED, \$company = \"" . $companies[0]['name'] . "\")</h2>";
        renderProducts(SearchService::searchProducts("with", SearchService::SORT_TOP_RATED, $companies[0]['id']));
        // @TODO end of example service usage, remove later.
        ?>
        <?php LayoutService::renderFooter(); ?>
    </body>
</html>
