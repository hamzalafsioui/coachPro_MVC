<?php

namespace App\Repositories;

use App\Interfaces\ReviewRepositoryInterface;
use App\Models\Database;
use PDO;
use PDOException;

class ReviewRepository implements ReviewRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    private function tableExists(string $tableName): bool
    {
        try {
            $stmt = $this->db->prepare("SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = ?)");
            $stmt->execute([$tableName]);
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCoachReviews(int $coachId): array
    {
        $hasRepliesTable = $this->tableExists('review_replies');


        if ($hasRepliesTable) {
            $sql = "
                SELECT 
    r.id,
    r.rating,
    r.comment,
    r.created_at,
    CONCAT(u.firstname, ' ', u.lastname) AS client,
    res.id AS reservation_id,
    STRING_AGG(s.name, ', ') AS session_types,
    rr.id AS reply_id,
    rr.reply_text,
    rr.created_at AS reply_date
FROM reviews r
JOIN reservations res ON r.reservation_id = res.id
JOIN users u ON r.author_id = u.id
LEFT JOIN coach_sports cs ON cs.coach_id = res.coach_id
LEFT JOIN sports s ON s.id = cs.sport_id
LEFT JOIN review_replies rr ON rr.review_id = r.id
WHERE res.coach_id = ?
GROUP BY
    r.id,
    r.rating,
    r.comment,
    r.created_at,
    CONCAT(u.firstname, ' ', u.lastname),
    res.id,
    rr.id,
    rr.reply_text,
    rr.created_at
ORDER BY r.created_at DESC;

            ";
        } else {
            $sql = "
                SELECT 
    r.id,
    r.rating,
    r.comment,
    r.created_at,
    CONCAT(u.firstname, ' ', u.lastname) AS client,
    res.id AS reservation_id,
    STRING_AGG(s.name, ', ') AS session_types,
    NULL AS reply_id,
    NULL AS reply_text,
    NULL AS reply_date
FROM reviews r
JOIN reservations res ON r.reservation_id = res.id
JOIN users u ON r.author_id = u.id
LEFT JOIN coach_sports cs ON cs.coach_id = res.coach_id
LEFT JOIN sports s ON s.id = cs.sport_id
WHERE res.coach_id = ?
GROUP BY
    r.id,
    r.rating,
    r.comment,
    r.created_at,
    CONCAT(u.firstname, ' ', u.lastname),
    res.id
ORDER BY r.created_at DESC;

            ";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coachId]);

        $reviews = [];
        $reviewMap = [];

        while ($row = $stmt->fetch()) {
            $reviewId = (int)$row['id'];
            if (!isset($reviewMap[$reviewId])) {

                $reviewMap[$reviewId] = $row;
                $reviewMap[$reviewId]['has_reply'] = !empty($row['reply_id']);
            }
        }
        return array_values($reviewMap);
    }

    public function create(int $reservationId, int $authorId, int $rating, string $comment): bool
    {

        try {
            $this->db->beginTransaction();

            $checkStmt = $this->db->prepare("
                SELECT r.id, s.name as status_name
                FROM reservations r
                JOIN statuses s ON r.status_id = s.id
                WHERE r.id = ? AND r.sportif_id = ?
            ");
            $checkStmt->execute([$reservationId, $authorId]);
            $reservation = $checkStmt->fetch();

            if (!$reservation || $reservation['status_name'] !== 'completed') {
                $this->db->rollBack();
                return false;
            }

            $stmt = $this->db->prepare("INSERT INTO reviews (reservation_id, author_id, rating, comment) VALUES (?, ?, ?, ?)");
            $success = $stmt->execute([$reservationId, $authorId, $rating, $comment]);

            if ($success) {
                $this->db->commit();
                return true;
            }
            $this->db->rollBack();
            return false;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    public function hasReview(int $reservationId): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM reviews WHERE reservation_id = ?");
        $stmt->execute([$reservationId]);
        return $stmt->fetch() !== false;
    }

    public function addReply(int $reviewId, int $coachId, string $replyText): bool
    {
        // NOT Implemented Yet
        return true;
    }

    public function getCoachReviewStats(int $coachId): array
    {
        $sql = "
            SELECT 
                COUNT(*) as total_reviews,
                AVG(rating) as avg_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as rating_5,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as rating_4,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as rating_3,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as rating_2,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as rating_1
            FROM reviews r
            JOIN reservations res ON r.reservation_id = res.id
            WHERE res.coach_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coachId]);
        $row = $stmt->fetch();

        if (!$row) {
            return [
                'avg_rating' => 0,
                'total_reviews' => 0,
                'rating_breakdown' => [
                    5 => 0,
                    4 => 0,
                    3 => 0,
                    2 => 0,
                    1 => 0
                ]
            ];
        }

        return [
            'avg_rating' => (float)$row['avg_rating'],
            'total_reviews' => (int)$row['total_reviews'],
            'rating_breakdown' => [
                5 => (int)$row['rating_5'],
                4 => (int)$row['rating_4'],
                3 => (int)$row['rating_3'],
                2 => (int)$row['rating_2'],
                1 => (int)$row['rating_1']
            ]
        ];
    }
}
