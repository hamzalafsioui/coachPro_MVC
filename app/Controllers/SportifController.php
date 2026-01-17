<?php

declare(strict_types=1);

namespace App\Controllers;

use Controller;
use App\Repositories\SportifRepository;

class SportifController extends Controller
{
    private SportifRepository $sportifRepo;

    public function __construct()
    {
        $this->sportifRepo = new SportifRepository();
    }

    private function checkAuth(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'sportif') {
            $this->redirect('/login');
            exit;
        }
        return $_SESSION['user'];
    }

    public function home(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            if ($_SESSION['role'] === 'coach') {
                $this->redirect('/coach/dashboard');
            } else {
                $this->redirect('/sportif/dashboard');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function dashboard(): void
    {
        $user = $this->checkAuth();
        $sportifId = (int)$user['id'];

        $sportifObj = $this->sportifRepo->findByUserId($sportifId);

        if (!$sportifObj) {
            $this->redirect('/logout');
            return;
        }

        $stats = $this->sportifRepo->getStats($sportifId);
        $upcoming_session = $this->sportifRepo->getNextSession($sportifId);
        $recent_activities = $this->sportifRepo->getRecentActivity($sportifId);
        $weekly_activity = $this->sportifRepo->getWeeklyActivity($sportifId);

        $this->render('sportif.dashboard', [
            'sportifObj' => $sportifObj,
            'stats' => $stats,
            'upcoming_session' => $upcoming_session,
            'recent_activities' => $recent_activities,
            'weekly_activity' => $weekly_activity,
            'user' => $user
        ]);
    }

    public function coaches(): void
    {
        $user = $this->checkAuth();
        $coachRepo = new \App\Repositories\CoachRepository();
        $coaches = $coachRepo->getAllCoaches();

        // Also need sports
        $stmt = \App\Models\Database::getInstance()->query("SELECT * FROM sports");
        $sports = $stmt->fetchAll();

        $this->render('sportif.coaches', [
            'coaches' => $coaches,
            'sports' => $sports,
            'user' => $user
        ]);
    }

    public function seances(): void
    {
        $user = $this->checkAuth();
        $reservationRepo = new \App\Repositories\ReservationRepository();
        $reservations = $reservationRepo->getSportifReservations((int)$user['id']);

        $this->render('sportif.seances', [
            'reservations' => $reservations,
            'user' => $user
        ]);
    }

    public function history(): void
    {
        $this->seances();
    }

    public function profile(): void
    {
        $user = $this->checkAuth();
        $sportifObj = $this->sportifRepo->findByUserId((int)$user['id']);

        $this->render('sportif.profile', [
            'sportifObj' => $sportifObj,
            'user' => $user
        ]);
    }

    public function coachDetails(int $id): void
    {
        $user = $this->checkAuth();

        $coachRepo = new \App\Repositories\CoachRepository();
        $coach = $coachRepo->find($id);

        if (!$coach) {
            $this->redirect('/sportif/coaches');
            return;
        }

        $availabilityRepo = new \App\Repositories\AvailabilityRepository();
        $raw_availabilities = $availabilityRepo->getByCoachId($id);

        $availability_by_date = [];
        foreach ($raw_availabilities as $row) {
            
            if (isset($row['is_available']) && !$row['is_available']) continue;

            
            $today = date('Y-m-d');
            if (strtotime((string)$row['date']) < strtotime($today)) continue;

            $date_key = (string)$row['date'];
            if (!isset($availability_by_date[$date_key])) {
                $availability_by_date[$date_key] = [];
            }

            $availability_by_date[$date_key][] = [
                'id' => (int)$row['id'],
                'time' => date('H:i', strtotime((string)$row['start_time'])),
                'date' => $row['date']
            ];
        }

        // Sort and limit
        ksort($availability_by_date);
        $availability_by_date = array_slice($availability_by_date, 0, 14, true);

        $reviewRepo = new \App\Repositories\ReviewRepository();
        $reviews = $reviewRepo->getCoachReviews($id);

        $this->render('sportif.coach_details', [
            'coach' => $coach,
            'specialties' => $coachRepo->getSpecialties($id),
            'availability_by_date' => $availability_by_date,
            'reviews' => $reviews,
            'user' => $user
        ]);
    }
}
