<?php

namespace App\Repositories;

use App\Interfaces\CoachRepositoryInterface;
use App\Models\Coach;
use App\Models\Database;
use PDO;

class CoachRepository implements CoachRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?Coach
    {
       
        $stmt = $this->db->prepare("
            SELECT u.*, cp.*, cp.id as coach_id 
            FROM users u
            JOIN coach_profiles cp ON u.id = cp.user_id
            WHERE cp.id = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->mapToCoach($data);
        }

        return null;
    }

    public function findByUserId(int $userId): ?Coach
    {
        $stmt = $this->db->prepare("
            SELECT u.*, cp.*, cp.id as coach_id 
            FROM users u
            JOIN coach_profiles cp ON u.id = cp.user_id
            WHERE u.id = ?
        ");
        $stmt->execute([$userId]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->mapToCoach($data);
        }

        return null;
    }

    public function create(array $data): ?int
    {
        
        $stmt = $this->db->prepare("INSERT INTO coach_profiles (user_id, bio, experience_years, hourly_rate, certifications) VALUES (?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $data['user_id'],
            $data['bio'] ?? null,
            $data['experience_years'] ?? 0,
            $data['hourly_rate'] ?? 50.00,
            $data['certifications'] ?? null
        ]);

        if ($success) {
            return (int)$this->db->lastInsertId();
        }
        return null;
    }

    public function updateProfile(int $coachId, array $data): bool
    {
        $fields = [];
        $values = [];

        if (isset($data['bio'])) {
            $fields[] = 'bio = ?';
            $values[] = $data['bio'];
        }
        if (isset($data['experience_years'])) {
            $fields[] = 'experience_years = ?';
            $values[] = $data['experience_years'];
        }
        if (isset($data['hourly_rate'])) {
            $fields[] = 'hourly_rate = ?';
            $values[] = $data['hourly_rate'];
        }
        if (isset($data['certifications'])) {
            $fields[] = 'certifications = ?';
            $values[] = $data['certifications'];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE coach_profiles SET " . implode(', ', $fields) . " WHERE id = ?";
        $values[] = $coachId;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function getAllCoaches(): array
    {
        
        $sql = "
            SELECT
                cp.id,
                u.firstname,
                u.lastname,
                u.email,
                cp.bio,
                cp.experience_years,
                cp.rating_avg,
                cp.photo,
                STRING_AGG(s.name, ', ') as specialties,
                (SELECT COUNT(*) FROM reviews r JOIN reservations res ON r.reservation_id = res.id WHERE res.coach_id = cp.id) as review_count
            FROM coach_profiles cp
            JOIN users u ON cp.user_id = u.id
            LEFT JOIN coach_sports cs ON cp.id = cs.coach_id
            LEFT JOIN sports s ON cs.sport_id = s.id
            GROUP BY cp.id, u.firstname, u.lastname, u.email, cp.bio, cp.experience_years, cp.rating_avg, cp.photo
        ";

        $stmt = $this->db->query($sql);
        $coaches = [];
        $icons = ['fas fa-user-ninja', 'fas fa-leaf', 'fas fa-fist-raised', 'fas fa-apple-alt', 'fas fa-user-shield'];

        while ($row = $stmt->fetch()) {
            srand((int)$row['id']);
            $icon = $icons[array_rand($icons)];
            srand();

            $coaches[] = [
                'id' => (int)$row['id'],
                'name' => $row['firstname'] . ' ' . $row['lastname'],
                'rating' => (float)$row['rating_avg'],
                'reviews' => (int)$row['review_count'],
                'specialties' => $row['specialties'] ? explode(', ', $row['specialties']) : ['Training'],
                'bio' => $row['bio'] ?: 'No bio available.',
                'image' => $icon
            ];
        }

        return $coaches;
    }

    public function getCoachStats(int $coachId): array
    {

        $stats = [
            'total_sessions' => 0,
            'total_clients' => 0,
            'rating' => 0
        ];

        // Total Sessions
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservations WHERE coach_id = ? AND status_id = (SELECT id FROM statuses WHERE name = 'completed')");
        $stmt->execute([$coachId]);
        $stats['total_sessions'] = (int)$stmt->fetchColumn();

        // Total Clients
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT sportif_id) FROM reservations WHERE coach_id = ?");
        $stmt->execute([$coachId]);
        $stats['total_clients'] = (int)$stmt->fetchColumn();

        // Rating
        $stmt = $this->db->prepare("SELECT rating_avg FROM coach_profiles WHERE id = ?");
        $stmt->execute([$coachId]);
        $stats['rating'] = (float)$stmt->fetchColumn();

        return $stats;
    }

    private function mapToCoach(array $data): Coach
    {
        $coach = new Coach();
        $coach->setId((int)$data['user_id']);
        $coach->setCoachId((int)$data['coach_id']);
        $coach->setFirstname($data['firstname']);
        $coach->setLastname($data['lastname']);
        $coach->setEmail($data['email']);
        $coach->setRoleId((int)($data['role_id'] ?? 0));

        $coach->setBio($data['bio'] ?? '');
        $coach->setExperienceYears((int)($data['experience_years'] ?? 0));
        $coach->setCertifications($data['certifications'] ?? '');
        $coach->setRatingAvg((float)($data['rating_avg'] ?? 0.0));
        $coach->setHourlyRate((float)($data['hourly_rate'] ?? 50.0));
        $coach->setPhoto($data['photo'] ?? null);

        return $coach;
    }
    public function getClients(int $coachId): array
    {
        $stmt = $this->db->prepare("
            SELECT DISTINCT
                u.id,
                u.firstname,
                u.lastname,
                u.email,
                (SELECT s.name FROM statuses s JOIN reservations res ON s.id = res.status_id WHERE res.sportif_id = u.id AND res.coach_id = ? ORDER BY res.created_at DESC LIMIT 1) as status,
                'Premium Plan' as plan,
                85 as progress,
                '2023-11-15' as join_date,
                '2 days ago' as last_session
            FROM users u
            JOIN reservations r ON u.id = r.sportif_id
            WHERE r.coach_id = ?
        ");
        $stmt->execute([$coachId, $coachId]);
        $clients = [];

        while ($row = $stmt->fetch()) {
            $clients[] = [
                'id' => (int)$row['id'],
                'name' => $row['firstname'] . ' ' . $row['lastname'],
                'status' => $row['status'] ?? 'pending',
                'plan' => $row['plan'],
                'progress' => $row['progress'],
                'join_date' => $row['join_date'],
                'last_session' => $row['last_session'],
                'avatar' => strtoupper($row['firstname'][0] . $row['lastname'][0])
            ];
        }
        return $clients;
    }

    public function getSpecialties(int $coachId): array
    {
        $stmt = $this->db->prepare("
            SELECT s.name 
            FROM sports s
            JOIN coach_sports cs ON s.id = cs.sport_id
            WHERE cs.coach_id = ?
        ");
        $stmt->execute([$coachId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

   

}
