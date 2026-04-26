<?php require_once __DIR__ . '/../src/index.php'; ?>
<?php
    $lastCache = CacheService::memoize(fn() => [time()], ['__METHOD__', 'first argument', 'last argument'], CacheService::FIVE_SECONDS);
    CacheService::invalidate(['invalidated']);
    $invalidatedCache = CacheService::memoize(fn() => time(), ['invalidated']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php LayoutService::renderHeaders("root"); ?>
    </head>
    <body>
        root
        <br>
        <?php echo "Last cache: " . $lastCache[0]; ?>
        <br>
        <?php echo "Invalidated cache: " . $invalidatedCache; ?>
    </body>
</html>
