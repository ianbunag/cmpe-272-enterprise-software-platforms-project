<?php

require_once __DIR__ . '/DatabaseService.php';

class TrackingService
{
    public static function trackVisit(string $productId, string $userId): void
    {
        try {
            $pdo = DatabaseService::getPdo();

            $userSql = "INSERT INTO user_visit_count (product_id, user_id, visit_count, updated_on) 
                    VALUES (?, ?, 1, NOW()) 
                    ON DUPLICATE KEY UPDATE 
                    visit_count = IF(updated_on <= NOW() - INTERVAL 1 MINUTE, visit_count + 1, visit_count),
                    updated_on = IF(updated_on <= NOW() - INTERVAL 1 MINUTE, NOW(), updated_on)";

            $userStmt = $pdo->prepare($userSql);
            $userStmt->execute([$productId, $userId]);

            if ($userStmt->rowCount() > 0) {
                $totalSql = "INSERT INTO visit_count (product_id, visit_count, updated_on) 
                         VALUES (?, 1, NOW()) 
                         ON DUPLICATE KEY UPDATE 
                         visit_count = visit_count + 1, 
                         updated_on = NOW()";
                $pdo->prepare($totalSql)->execute([$productId]);
            }
        } catch (Exception $e) {
            error_log("Failed to track visit for product " . $productId . " and user " . $userId . " " . $e->getMessage());
        }
    }

    public function getVisits(array $productIds): array
    {
        $results = array_fill_keys($productIds, 0);

        if (empty($productIds)) {
            return $results;
        }

        try {
            $pdo = DatabaseService::getPdo();

            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
            $sql = "SELECT product_id, visit_count FROM visit_count WHERE product_id IN ($placeholders)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($productIds);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[$row['product_id']] = (int)$row['visit_count'];
            }
        } catch (Exception $e) {
            error_log("Failed to fetch visits for products " . implode(', ', $productIds) . " " . $e->getMessage());
        }

        return $results;
    }
}
