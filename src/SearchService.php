<?php

require_once __DIR__ . "/CacheService.php";
require_once __DIR__ . "/VersionService.php";

class SearchService
{
    public static function getRawProducts(string $productsApiUrl): array
    {
        return CacheService::memoize(
            function () use ($productsApiUrl) {
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
                    $result[] = [
                        'product_id' => $item['id'] ?? '',
                        'name' => $item['name'] ?? '',
                        'price' => $item['price'] ?? '',
                        'description' => $item['description'] ?? '',
                        'imageUrl' => $item['imageUrl'] ?? '',
                        'websiteUrl' => $item['url'] ?? '',
                    ];
                }
                return $result;
            },
            ['SearchService::getRawProducts', $productsApiUrl],
            CacheService::FIVE_MINUTES
        );
    }
}
