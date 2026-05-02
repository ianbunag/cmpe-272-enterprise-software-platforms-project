<?php

require_once __DIR__ . '/DatabaseService.php';

class RatingService
{
    public static function submitReview(string $productId, string $userId, string $userDisplayName, int $rating, string $comment): void
    {
        try {
            if (!in_array($rating, [1, 2, 3, 4, 5])) {
                error_log("submitReview: Invalid rating $rating for product $productId user $userId");
                return;
            }
            if (mb_strlen($comment) > 4096) {
                error_log("submitReview: comment too long for product $productId user $userId");
                return;
            }
            $pdo = DatabaseService::getPdo();
            // Check if review exists
            $stmt = $pdo->prepare('SELECT 1 FROM product_review WHERE product_id = ? AND user_id = ? LIMIT 1');
            $stmt->execute([$productId, $userId]);
            if ($stmt->fetchColumn()) {
                error_log("submitReview: Review already exists for product $productId user $userId");
                return;
            }
            // Insert review
            $stmt = $pdo->prepare('INSERT INTO product_review (product_id, user_id, user_display_name, rating, comment, created_on) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)');
            $stmt->execute([$productId, $userId, $userDisplayName, $rating, $comment]);
            // Update or insert product_review_count using DB-side calculation
            $stmt = $pdo->prepare('SELECT rating_average, rating_count FROM product_review_count WHERE product_id = ?');
            $stmt->execute([$productId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $stmt = $pdo->prepare('UPDATE product_review_count SET rating_average = ((rating_average * rating_count) + ?) / (rating_count + 1), rating_count = rating_count + 1, updated_on = CURRENT_TIMESTAMP WHERE product_id = ?');
                $stmt->execute([$rating, $productId]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO product_review_count (product_id, rating_average, rating_count, updated_on) VALUES (?, ?, 1, CURRENT_TIMESTAMP)');
                $stmt->execute([$productId, $rating]);
            }
        } catch (Throwable $e) {
            error_log("submitReview: Exception for product $productId user $userId: " . $e->getMessage());
        }
        return;
    }

    public static function getReviews(array $productIds): array
    {
        $result = [];
        foreach ($productIds as $pid) {
            $result[$pid] = ['rating_average' => 0, 'rating_count' => 0];
        }
        try {
            if (empty($productIds)) return $result;
            $pdo = DatabaseService::getPdo();
            $in = str_repeat('?,', count($productIds) - 1) . '?';
            $stmt = $pdo->prepare("SELECT product_id, rating_average, rating_count FROM product_review_count WHERE product_id IN ($in)");
            $stmt->execute($productIds);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $result[$row['product_id']] = [
                    'rating_average' => (float)$row['rating_average'],
                    'rating_count' => (int)$row['rating_count']
                ];
            }
        } catch (Throwable $e) {
            error_log("getReviews: Exception for productIds [" . implode(',', $productIds) . "]: " . $e->getMessage());
        }
        return $result;
    }

    public static function getCurrentUserReview(string $productId, string $userId): ?array
    {
        try {
            $pdo = DatabaseService::getPdo();
            $stmt = $pdo->prepare('SELECT * FROM product_review WHERE product_id = ? AND user_id = ? LIMIT 1');
            $stmt->execute([$productId, $userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (Throwable $e) {
            error_log("getCurrentUserReview: Exception for product $productId user $userId: " . $e->getMessage());
            return null;
        }
    }

    public static function getBestUserReview(string $productId, array $exceptUserIds = []): ?array
    {
        try {
            $pdo = DatabaseService::getPdo();
            $query = 'SELECT * FROM product_review WHERE product_id = ?';
            $params = [$productId];
            if (!empty($exceptUserIds)) {
                $in = implode(',', array_fill(0, count($exceptUserIds), '?'));
                $query .= " AND user_id NOT IN ($in)";
                $params = array_merge($params, $exceptUserIds);
            }
            $query .= ' ORDER BY rating DESC, created_on DESC LIMIT 1';
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (Throwable $e) {
            error_log("getBestUserReview: Exception for product $productId: " . $e->getMessage());
            return null;
        }
    }

    public static function getWorstUserReview(string $productId, array $exceptUserIds = []): ?array
    {
        try {
            $pdo = DatabaseService::getPdo();
            $query = 'SELECT * FROM product_review WHERE product_id = ?';
            $params = [$productId];
            if (!empty($exceptUserIds)) {
                $in = implode(',', array_fill(0, count($exceptUserIds), '?'));
                $query .= " AND user_id NOT IN ($in)";
                $params = array_merge($params, $exceptUserIds);
            }
            $query .= ' ORDER BY rating ASC, created_on DESC LIMIT 1';
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (Throwable $e) {
            error_log("getWorstUserReview: Exception for product $productId: " . $e->getMessage());
            return null;
        }
    }
}
