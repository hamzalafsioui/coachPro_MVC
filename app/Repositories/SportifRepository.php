<?php

namespace App\Repositories;

use App\Interfaces\SportifRepositoryInterface;
use App\Models\Sportif;
use App\Models\Database;
use PDO;

class SportifRepository implements SportifRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?Sportif
    {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->mapToSportif($data);
        }
        return null;
    }

    public function findByUserId(int $userId): ?Sportif
    {
        return $this->find($userId);
    }

    public function create(array $data): bool
    {
        // Handled by UserRepository => the same fields
        return true;
    }

    public function getStats(int $sportifId): array
    {
        
        $stats = [
            'workouts' => 0,
            'calories' => '4,250', // Mock data
            'active_minutes' => 340 // Mock data
        ];

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM reservations r
            JOIN statuses s ON r.status_id = s.id
            WHERE r.sportif_id = ? AND s.name IN ('confirmed', 'completed')
        ");
        $stmt->execute([$sportifId]);
        $row = $stmt->fetch();
        if ($row) {
            $stats['workouts'] = (int)$row['total'];
        }

        return $stats;
    }

    public function getNextSession(int $sportifId): ?array
    {
        
        $sql = "
            SELECT
                r.id,
                u.firstname as coach_firstname,
                u.lastname as coach_lastname,
                a.date,
                a.start_time,
                a.end_time,
                s.name as status,
                STRING_AGG(sp.name, ', ') as sports
            FROM reservations r
            JOIN availabilities a ON r.availability_id = a.id
            JOIN coach_profiles cp ON r.coach_id = cp.id
            JOIN users u ON cp.user_id = u.id
            JOIN statuses s ON r.status_id = s.id
            LEFT JOIN coach_sports cs ON cs.coach_id = r.coach_id
            LEFT JOIN sports sp ON sp.id = cs.sport_id
            WHERE r.sportif_id = ?
            AND (a.date > CURRENT_DATE OR (a.date = CURRENT_DATE AND a.start_time > CURRENT_TIME))
            AND s.name = 'confirmed'
            GROUP BY r.id, u.firstname, u.lastname, a.date, a.start_time, a.end_time, s.name
            ORDER BY a.date ASC, a.start_time ASC
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sportifId]);
        $row = $stmt->fetch();

        if ($row) {
            $timestamp = strtotime($row['date']);
            $today = strtotime(date('Y-m-d'));
            $tomorrow = strtotime('+1 day', $today);

            if ($timestamp === $today) {
                $displayDate = 'Today';
            } elseif ($timestamp === $tomorrow) {
                $displayDate = 'Tomorrow';
            } else {
                $displayDate = date('M j', $timestamp);
            }

            return [
                'coach' => $row['coach_firstname'] . ' ' . $row['coach_lastname'],
                'type' => $row['sports'] ?: 'Personal Training',
                'date' => $displayDate,
                'time' => date('H:i', strtotime((string)$row['start_time'])) . ' - ' . date('H:i', strtotime((string)$row['end_time'])),
                'avatar' => strtoupper($row['coach_firstname'][0] . $row['coach_lastname'][0])
            ];
        }

        return null;
    }

    public function getRecentActivity(int $sportifId, int $limit = 3): array
    {
        
        $sql = "
            SELECT
                r.id,
                u.firstname as coach_firstname,
                u.lastname as coach_lastname,
                a.date,
                s.name as status,
                STRING_AGG(sp.name, ', ') as sports
            FROM reservations r
            JOIN availabilities a ON r.availability_id = a.id
            JOIN coach_profiles cp ON r.coach_id = cp.id
            JOIN users u ON cp.user_id = u.id
            JOIN statuses s ON r.status_id = s.id
            LEFT JOIN coach_sports cs ON cs.coach_id = r.coach_id
            LEFT JOIN sports sp ON sp.id = cs.sport_id
            WHERE r.sportif_id = ?
            GROUP BY r.id, u.firstname, u.lastname, a.date, a.start_time, s.name
            ORDER BY a.date DESC, a.start_time DESC
            LIMIT " . (int)$limit;

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sportifId]);

        $activities = [];
        while ($row = $stmt->fetch()) {
            $timestamp = strtotime($row['date']);
            $today = strtotime(date('Y-m-d'));
            $diff = (int)floor(($today - $timestamp) / (60 * 60 * 24));

            if ($diff === 0) $displayDate = 'Today';
            elseif ($diff === 1) $displayDate = 'Yesterday';
            elseif ($diff < 7) $displayDate = $diff . ' days ago';
            else $displayDate = date('M j', $timestamp);

            $activities[] = [
                'title' => $row['sports'] ?: 'Workout',
                'date' => $displayDate,
                'coach' => $row['coach_firstname'] . ' ' . $row['coach_lastname']
            ];
        }

        return $activities;
    }

    public function getWeeklyActivity(int $sportifId): array
    {
        // Mock data
        return [
            ['day' => 'M', 'height' => '40%'],
            ['day' => 'T', 'height' => '70%'],
            ['day' => 'W', 'height' => '30%'],
            ['day' => 'T', 'height' => '85%'],
            ['day' => 'F', 'height' => '60%'],
            ['day' => 'S', 'height' => '90%'],
            ['day' => 'S', 'height' => '20%'],
        ];
    }

    private function mapToSportif(array $data): Sportif
    {
        $sportif = new Sportif();
        $sportif->setId((int)$data['id']);
        $sportif->setFirstname($data['firstname']);
        $sportif->setLastname($data['lastname']);
        $sportif->setEmail($data['email']);
        $sportif->setPhone($data['phone'] ?? null);
        $sportif->setRoleId((int)$data['role_id']);

        return $sportif;
    }
}
