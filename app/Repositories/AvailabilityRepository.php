<?php

namespace App\Repositories;

use App\Interfaces\AvailabilityRepositoryInterface;
use App\Models\Availability;
use App\Models\Database;
use PDO;
use DateTime;
use DateInterval;
use DatePeriod;
use Exception;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO availabilities (coach_id, date, start_time, end_time, is_available) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['coach_id'],
            $data['date'],
            $data['start_time'],
            $data['end_time'],
            ($data['is_available'] ?? true) ? 'true' : 'false'
        ]);
    }

    public function getByCoachId(int $coachId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM availabilities WHERE coach_id = ? ORDER BY date ASC, start_time ASC");
        $stmt->execute([$coachId]);
        return $stmt->fetchAll();
    }


    public function saveCoachAvailability(int $coachId, array $schedule): bool
    {
        try {
            $this->db->beginTransaction();

            // Delete existing recurring slots for this coach
            $stmt = $this->db->prepare("DELETE FROM coach_recurring_slots WHERE coach_id = ?");
            $stmt->execute([$coachId]);

            // Delete future availabilities for this coach that don't have reservations
            $stmt = $this->db->prepare("DELETE FROM availabilities WHERE coach_id = ? AND date >= CURRENT_DATE AND id NOT IN (SELECT availability_id FROM reservations)");
            $stmt->execute([$coachId]);

            // Prepare insert statements
            $stmtRecurring = $this->db->prepare("INSERT INTO coach_recurring_slots (coach_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmtAvailability = $this->db->prepare("INSERT INTO availabilities (coach_id, date, start_time, end_time, is_available) VALUES (?, ?, ?, ?, TRUE)");

            // Insert new recurring slots
            foreach ($schedule as $day => $data) {
                if (($data['active'] ?? false) && !empty($data['slots'])) {
                    foreach ($data['slots'] as $slot) {
                        $startTime = $slot[0];
                        $endTime = $slot[1];
                        $stmtRecurring->execute([$coachId, $day, $startTime, $endTime]);
                    }
                }
            }

            // Generate dates for next 30 days and insert into availabilities
            $begin = new DateTime();
            $end = new DateTime();
            $end->modify('+30 days');
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval, $end);

            foreach ($daterange as $date) {
                $dayOfWeek = strtolower($date->format('l'));
                if (isset($schedule[$dayOfWeek]) && ($schedule[$dayOfWeek]['active'] ?? false) && !empty($schedule[$dayOfWeek]['slots'])) {
                    $dateString = $date->format('Y-m-d');
                    foreach ($schedule[$dayOfWeek]['slots'] as $slot) {
                        $startTime = $slot[0];
                        $endTime = $slot[1];
                        $stmtAvailability->execute([$coachId, $dateString, $startTime, $endTime]);
                    }
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            error_log("Database Error in saveCoachAvailability: " . $e->getMessage());
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }

    public function getRecurringSchedule(int $coachId): array
    {
        $stmt = $this->db->prepare("SELECT day_of_week, start_time, end_time FROM coach_recurring_slots WHERE coach_id = ?");
        $stmt->execute([$coachId]);

        $schedule = [
            'monday' => ['active' => false, 'slots' => []],
            'tuesday' => ['active' => false, 'slots' => []],
            'wednesday' => ['active' => false, 'slots' => []],
            'thursday' => ['active' => false, 'slots' => []],
            'friday' => ['active' => false, 'slots' => []],
            'saturday' => ['active' => false, 'slots' => []],
            'sunday' => ['active' => false, 'slots' => []],
        ];

        while ($row = $stmt->fetch()) {
            $day = (string)$row['day_of_week'];
            if (isset($schedule[$day])) {
                $schedule[$day]['active'] = true;
                $schedule[$day]['slots'][] = [
                    date('H:i', strtotime((string)$row['start_time'])),
                    date('H:i', strtotime((string)$row['end_time']))
                ];
            }
        }

        return $schedule;
    }

    public function updateStatus(int $id, bool $isAvailable): bool
    {
        $stmt = $this->db->prepare("UPDATE availabilities SET is_available = ? WHERE id = ?");
        return $stmt->execute([$isAvailable ? 'true' : 'false', $id]);
    }
}
