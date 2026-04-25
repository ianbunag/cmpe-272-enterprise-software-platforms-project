<?php require_once __DIR__ . '/../../src/index.php'; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("shop/" . $_GET['id'] ?? null); ?>
    </head>
    <body>
        shop/<?php echo $_GET['id'] ?? null; ?>
    </body>
</html>
