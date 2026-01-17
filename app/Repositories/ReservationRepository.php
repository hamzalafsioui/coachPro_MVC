<?php

namespace App\Repositories;

use App\Interfaces\ReservationRepositoryInterface;
use App\Models\Reservation;
use App\Models\Database;
use PDO;

class ReservationRepository implements ReservationRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?Reservation
    {
        $stmt = $this->db->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            $res = new Reservation();

            return $res;
        }
        return null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO reservations (sportif_id, coach_id, availability_id, status_id, price, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $data['sportif_id'],
            $data['coach_id'],
            $data['availability_id'],
            $data['status_id'],
            $data['price']
        ]);
    }

    public function getByCoach(int $coachId): array
    {
        $sql = "
SELECT
    r.id,
    r.price,
    u.firstname,
    u.lastname,
    a.date,
    a.start_time,
    a.end_time,
    s.name AS status_name,
    STRING_AGG(sp.name, ', ') AS sports
FROM reservations r
JOIN users u ON r.sportif_id = u.id
JOIN availabilities a ON r.availability_id = a.id
JOIN statuses s ON r.status_id = s.id
LEFT JOIN coach_sports cs ON cs.coach_id = r.coach_id
LEFT JOIN sports sp ON sp.id = cs.sport_id
WHERE r.coach_id = ?
GROUP BY
    r.id,
    r.price,
    u.firstname,
    u.lastname,
    a.date,
    a.start_time,
    a.end_time,
    s.name
ORDER BY a.date DESC, a.start_time DESC;

";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coachId]);

        $reservations = [];
        while ($row = $stmt->fetch()) {
            $reservations[] = [
                'id' => (int)$row['id'],
                'client' => $row['firstname'] . ' ' . $row['lastname'],
                'avatar' => strtoupper($row['firstname'][0] . $row['lastname'][0]),
                'type' => $row['sports'] ?: 'Training',
                'date' => $row['date'],
                'time' => date('H:i', strtotime((string)$row['start_time'])) . ' - ' . date('H:i', strtotime((string)$row['end_time'])),
                'status' => $row['status_name'],
                'price' => '$' . number_format((float)$row['price'], 2)
            ];
        }

        return $reservations;
    }

    public function getCoachUpcomingSessions(int $coachId): array
    {

        $stmt = $this->db->prepare("
            SELECT 
                r.id,
                u.firstname as client_firstname,
                u.lastname as client_lastname,
                a.date,
                a.start_time,
                a.end_time,
                s.name as status,
                (SELECT STRING_AGG(name, ', ') FROM sports WHERE id IN (SELECT sport_id FROM coach_sports WHERE coach_id = ?)) as type
            FROM reservations r
            JOIN users u ON r.sportif_id = u.id
            JOIN availabilities a ON r.availability_id = a.id
            JOIN statuses s ON r.status_id = s.id
            WHERE r.coach_id = ? 
            AND (a.date > CURRENT_DATE OR (a.date = CURRENT_DATE AND a.start_time > CURRENT_TIME))
            ORDER BY a.date ASC, a.start_time ASC
            LIMIT 5
        ");

        $stmt->execute([$coachId, $coachId]);
        $sessions = [];

        while ($row = $stmt->fetch()) {
            $displayDate = date('M j, Y', strtotime($row['date']));
            $startTime = date('H:i', strtotime((string)$row['start_time']));
            $endTime = date('H:i', strtotime((string)$row['end_time']));

            $sessions[] = [
                'id' => $row['id'],
                'client' => $row['client_firstname'] . ' ' . $row['client_lastname'],
                'type' => $row['type'] ?? 'Training Session',
                'date' => $displayDate,
                'time' => $startTime . ' - ' . $endTime,
                'status' => ucfirst($row['status'])
            ];
        }

        return $sessions;
    }

    public function getSportifReservations(int $sportifId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                r.id,
                u.firstname as coach_firstname,
                u.lastname as coach_lastname,
                a.date,
                a.start_time,
                a.end_time,
                s.name as status,
                (SELECT STRING_AGG(name, ', ') FROM sports WHERE id IN (SELECT sport_id FROM coach_sports WHERE coach_id = r.coach_id)) as type
            FROM reservations r
            JOIN coach_profiles cp ON r.coach_id = cp.id
            JOIN users u ON cp.user_id = u.id
            JOIN availabilities a ON r.availability_id = a.id
            JOIN statuses s ON r.status_id = s.id
            WHERE r.sportif_id = ?
            ORDER BY a.date DESC, a.start_time DESC
        ");

        $stmt->execute([$sportifId]);
        $reservations = [];

        while ($row = $stmt->fetch()) {
            $reservations[] = [
                'id' => $row['id'],
                'coach' => $row['coach_firstname'] . ' ' . $row['coach_lastname'],
                'avatar' => strtoupper($row['coach_firstname'][0] . $row['coach_lastname'][0]),
                'type' => $row['type'] ?: 'Training Session',
                'date' => $row['date'],
                'time' => date('H:i', strtotime((string)$row['start_time'])) . ' - ' . date('H:i', strtotime((string)$row['end_time'])),
                'status' => $row['status']
            ];
        }
        return $reservations;
    }

    public function getSportifUpcomingSessions(int $sportifId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                r.id,
                u.firstname as coach_firstname,
                u.lastname as coach_lastname,
                a.date,
                a.start_time,
                a.end_time,
                s.name as status,
                (SELECT STRING_AGG(name, ', ') FROM sports WHERE id IN (SELECT sport_id FROM coach_sports WHERE coach_id = r.coach_id)) as type
            FROM reservations r
            JOIN coach_profiles cp ON r.coach_id = cp.id
            JOIN users u ON cp.user_id = u.id
            JOIN availabilities a ON r.availability_id = a.id
            JOIN statuses s ON r.status_id = s.id
            WHERE r.sportif_id = ? 
            AND (a.date > CURRENT_DATE OR (a.date = CURRENT_DATE AND a.start_time > CURRENT_TIME))
            ORDER BY a.date ASC, a.start_time ASC
        ");

        $stmt->execute([$sportifId]);
        $sessions = [];

        while ($row = $stmt->fetch()) {
            $sessions[] = [
                'id' => $row['id'],
                'coach' => $row['coach_firstname'] . ' ' . $row['coach_lastname'],
                'type' => $row['type'] ?: 'Training Session',
                'date' => $row['date'],
                'time' => date('H:i', strtotime((string)$row['start_time'])) . ' - ' . date('H:i', strtotime((string)$row['end_time'])),
                'status' => $row['status']
            ];
        }

        return $sessions;
    }

    public function updateStatus(int $reservationId, int $statusId): bool
    {
        $stmt = $this->db->prepare("UPDATE reservations SET status_id = ? WHERE id = ?");
        return $stmt->execute([$statusId, $reservationId]);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ?: null;
    }
}
