<?php

require_once __DIR__ . "/CacheService.php";
require_once __DIR__ . "/VersionService.php";
require_once __DIR__ . '/DatabaseService.php';
require_once __DIR__ . '/TrackingService.php';
require_once __DIR__ . '/RatingService.php';

class SearchService
{
    public const QUERY_NONE = null;
    public const COMPANY_NONE = null;

    public const SORT_NAME = 'sort_name';
    public const SORT_TRENDING = 'sort_trending';
    public const SORT_TOP_RATED = 'sort_top_rated';

    public static function getCompanies(): array
    {
        // Return all enabled companies with id, name, and productsApiUrl
        try {
            $stmt = DatabaseService::getPdo()->query('SELECT id, name, productsApiUrl FROM company WHERE enabled = 1');
            $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!is_array($companies)) {
                return [];
            }
            return array_map(function ($row) {
                return [
                    'id' => (int)$row['id'],
                    'name' => $row['name'],
                    'productsApiUrl' => $row['productsApiUrl'],
                ];
            }, $companies);
        } catch (Throwable $e) {
            error_log('SearchService::getCompanies error: ' . $e->getMessage());
            return [];
        }
    }

    public static function searchProducts(
        ?string $query = self::QUERY_NONE,
        ?string $sort = self::SORT_NAME,
        ?int $company = self::COMPANY_NONE
    ): array
    {
        try {
            // Get products, filtered by company if provided
            $products = self::getProducts($company);
            if (!is_array($products)) {
                $products = [];
            }

            // Filter by query if provided
            if ($query !== self::QUERY_NONE && $query !== null && $query !== '') {
                $q = mb_strtolower($query);
                $products = array_filter($products, function ($item) use ($q) {
                    return (
                        mb_strpos(mb_strtolower($item['name'] ?? ''), $q) !== false ||
                        mb_strpos(mb_strtolower($item['price'] ?? ''), $q) !== false ||
                        mb_strpos(mb_strtolower($item['description'] ?? ''), $q) !== false ||
                        mb_strpos(mb_strtolower($item['company_name'] ?? ''), $q) !== false
                    );
                });
                $products = array_values($products);
            }

            // Fetch real visit counts from TrackingService
            $productIds = array_column($products, 'product_id');
            $visitCounts = TrackingService::getVisits($productIds);
            $reviewCounts = RatingService::getReviews($productIds);

            // Insert visit_count, rating_average, rating_count
            foreach ($products as $i => &$item) {
                $item['visit_count'] = $visitCounts[$item['product_id']] ?? 0;
                $item['rating_average'] = $reviewCounts[$item['product_id']]['rating_average'] ?? 0;
                $item['rating_count'] = $reviewCounts[$item['product_id']]['rating_count'] ?? 0;
            }
            unset($item);

            // Sorting
            if ($sort === self::SORT_NAME) {
                usort($products, function ($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
            } elseif ($sort === self::SORT_TRENDING) {
                usort($products, fn($a, $b) => $b['visit_count'] <=> $a['visit_count']);
            } elseif ($sort === self::SORT_TOP_RATED) {
                usort($products, fn($a, $b) => $b['rating_average'] <=> $a['rating_average']);
            }

            return $products;
        } catch (Throwable $e) {
            error_log('SearchService::searchProducts error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getProduct(string $productId): array
    {
        $ids = self::decodeProductId($productId);
        if (!$ids['company_id']) {
            return [];
        }
        $products = self::getProducts($ids['company_id']);
        foreach ($products as $product) {
            if ((string)$product['product_id'] === $productId) {
                $visitCounts = TrackingService::getVisits([$productId]);
                $reviewCounts = RatingService::getReviews([$productId]);
                $product['visit_count'] = $visitCounts[$productId] ?? 0;
                $product['rating_average'] = $reviewCounts[$productId]['rating_average'] ?? 0;
                $product['rating_count'] = $reviewCounts[$productId]['rating_count'] ?? 0;
                return $product;
            }
        }

        return [];
    }

    public static function getProducts(?int $company = self::COMPANY_NONE): array
    {
        // If a company is specified, return its products. Otherwise, aggregate for all enabled companies.
        if ($company !== self::COMPANY_NONE && $company !== null) {
            return self::getRawProducts($company);
        }
        $companies = self::getCompanies();
        $allProducts = [];
        foreach ($companies as $c) {
            foreach (self::getRawProducts($c['id']) as $product) {
                $allProducts[] = $product;
            }
        }
        return $allProducts;
    }

    public static function getRawProducts(int $companyId): array
    {
        return CacheService::memoize(
            function () use ($companyId) {
                $stmt = DatabaseService::getPdo()->prepare('SELECT productsApiUrl, name FROM company WHERE id = ? AND enabled = 1 LIMIT 1');
                $stmt->execute([$companyId]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row || empty($row['productsApiUrl'])) {
                    error_log("SearchService::getRawProducts error: No productsApiUrl for company $companyId");
                    return [];
                }
                $productsApiUrl = $row['productsApiUrl'];
                $companyName = $row['name'];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $productsApiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Sun&String/' . VersionService::getVersion());
                $response = curl_exec($ch);
                $err = curl_error($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($err || $httpCode !== 200 || $response === false) {
                    error_log("SearchService::getRawProducts error: " . ($err ?: "HTTP $httpCode"));
                    return [];
                }

                $data = json_decode($response, true);
                if (!is_array($data)) {
                    error_log("SearchService::getRawProducts error: Invalid JSON");
                    return [];
                }

                $result = [];
                foreach ($data as $item) {
                    $productId = $item['id'] ?? '';
                    $result[] = [
                        'product_id' => self::encodeProductId($companyId, $productId),
                        'name' => $item['name'] ?? '',
                        'company_name' => $companyName,
                        'price' => $item['price'] ?? '',
                        'description' => $item['description'] ?? '',
                        'imageUrl' => $item['imageUrl'] ?? '',
                        'websiteUrl' => $item['url'] ?? '',
                    ];
                }
                return $result;
            },
            ['SearchService::getRawProducts', $companyId],
            CacheService::FIVE_MINUTES
        );
    }

    private static function encodeProductId(int $companyId, string $productId): string
    {
        $raw = $companyId . ':' . $productId;
        return bin2hex($raw);
    }

    public static function decodeProductId(string $pathId): array
    {
        $decoded = @hex2bin($pathId);
        if ($decoded === false) {
            return ['company_id' => null, 'company_product_id' => null];
        }
        $parts = explode(':', $decoded, 2);
        if (count($parts) !== 2) {
            return ['company_id' => null, 'company_product_id' => null];
        }
        return [
            'company_id' => is_numeric($parts[0]) ? (int)$parts[0] : null,
            'company_product_id' => $parts[1],
        ];
    }
}
