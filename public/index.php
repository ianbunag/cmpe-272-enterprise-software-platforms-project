<?php require_once __DIR__ . '/../src/index.php'; ?>
<?php
    $lastCache = CacheService::memoize(fn() => [time()], ['__METHOD__' , 'v1', 'first argument', 'last argument'], CacheService::FIVE_SECONDS);
    CacheService::invalidate(['invalidated', 'v1']);
    $invalidatedCache = CacheService::memoize(fn() => time(), ['invalidated', 'v1']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("Home"); ?>
    </head>
    <body>
        <?php LayoutService::renderNavigation(); ?>
        root
        <br>
        <?php echo "Last cache: " . $lastCache[0]; ?>
        <br>
        <?php echo "Invalidated cache: " . $invalidatedCache; ?>
    </body>
</html>
