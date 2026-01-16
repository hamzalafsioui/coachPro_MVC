<?php

declare(strict_types=1);

namespace App\Controllers;

use Controller;
use App\Repositories\CoachRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\AvailabilityRepository;

class CoachController extends Controller
{
    private CoachRepository $coachRepo;
    private ReservationRepository $reservationRepo;
    private AvailabilityRepository $availabilityRepo; 

    public function __construct()
    {
        $this->coachRepo = new CoachRepository();
        $this->reservationRepo = new ReservationRepository();
        $this->availabilityRepo = new AvailabilityRepository();
    }

    private function checkAuth(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'coach') {
            $this->redirect('/login');
            exit;
        }
        return $_SESSION['user'];
    }

    public function dashboard(): void
    {
        $user = $this->checkAuth();
        $userId = (int)$user['id'];

        
        $coachObj = $this->coachRepo->findByUserId($userId);

        if (!$coachObj) {

            $this->redirect('/logout');
            return;
        }

        $coachId = $coachObj->getCoachId();

        if ($coachId) {
            $stats = $this->coachRepo->getCoachStats($coachId);
            $upcoming_sessions = $this->reservationRepo->getCoachUpcomingSessions($coachId);
        } else {
            $stats = ['total_sessions' => 0, 'total_clients' => 0, 'rating' => 0];
            $upcoming_sessions = [];
        }

        $this->render('coach.dashboard', [
            'coachObj' => $coachObj,
            'stats' => $stats,
            'upcoming_sessions' => $upcoming_sessions,
            'user' => $user
        ]);
    }

    public function profile(): void
    {
        $user = $this->checkAuth();
        $coachObj = $this->coachRepo->findByUserId((int)$user['id']);

        $this->render('coach.profile', [
            'coachObj' => $coachObj,
            'user' => $user
        ]);
    }

    public function reservations(): void
    {
        $user = $this->checkAuth();
        $coachObj = $this->coachRepo->findByUserId((int)$user['id']);
        $coachId = $coachObj ? $coachObj->getCoachId() : null;

        $reservations = [];
        if ($coachId) {
            $reservations = $this->reservationRepo->getCoachUpcomingSessions($coachId);
        }

        $this->render('coach.reservations', [
            'reservations' => $reservations,
            'user' => $user
        ]);
    }

    public function seances(): void
    {
        $user = $this->checkAuth();
        $coachObj = $this->coachRepo->findByUserId((int)$user['id']);
        $coachId = $coachObj ? $coachObj->getCoachId() : null;

        $upcoming_sessions = [];
        if ($coachId) {
            $upcoming_sessions = $this->reservationRepo->getCoachUpcomingSessions($coachId);
        }

        $this->render('coach.seances', [
            'upcoming_sessions' => $upcoming_sessions,
            'user' => $user
        ]);
    }

    public function availability(): void
    {
        
        $user = $this->checkAuth();
        $coachObj = $this->coachRepo->findByUserId((int)$user['id']);
        $coachId = $coachObj ? $coachObj->getCoachId() : null;

        $availability = new AvailabilityRepository()->getRecurringSchedule($coachId);
        $this->render('coach.availability', [
            'availability' => $availability,
            'user' => $user
        ]);
    }

    public function clients(): void
    {
        $user = $this->checkAuth();
        $coachObj = $this->coachRepo->findByUserId((int)$user['id']);
        $coachId = $coachObj ? $coachObj->getCoachId() : null;

        $clients = [];
        if ($coachId) {
            $clients = $this->coachRepo->getClients($coachId);
        }

        $this->render('coach.clients', [
            'clients' => $clients,
            'user' => $user
        ]);
    }

    public function reviews(): void
    {
        $user = $this->checkAuth();
        $coachObj = $this->coachRepo->findByUserId((int)$user['id']);
        $coachId = $coachObj ? $coachObj->getCoachId() : null;

        $reviews = [];
        $stats = ['avg_rating' => 0, 'total_reviews' => 0, 'rating_breakdown' => []];

        if ($coachId) {
            $reviewRepo = new \App\Repositories\ReviewRepository();
            $reviews = $reviewRepo->getCoachReviews($coachId);
            $stats = $reviewRepo->getCoachReviewStats($coachId);
        }

        $this->render('coach.reviews', [
            'reviews' => $reviews,
            'overall_rating' => $stats['avg_rating'],
            'total_reviews' => $stats['total_reviews'],
            'rating_breakdown' => $stats['rating_breakdown'],
            'user' => $user
        ]);
    }
}
