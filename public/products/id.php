<?php require_once __DIR__ . '/../../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("products/" . $_GET['id'] ?? null); ?>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        products/<?php echo $_GET['id'] ?? null; ?>
    </body>
</html>
