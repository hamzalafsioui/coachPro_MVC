<?php

declare(strict_types=1);

namespace App\Controllers;

use Controller;
use App\Repositories\ReservationRepository;
use App\Repositories\CoachRepository;
use App\Repositories\AvailabilityRepository;

class ReservationController extends Controller
{
    private ReservationRepository $reservationRepo;
    private CoachRepository $coachRepo;
    private AvailabilityRepository $availabilityRepo;

    public function __construct()
    {
        $this->reservationRepo = new ReservationRepository();
        $this->coachRepo = new CoachRepository();
        $this->availabilityRepo = new AvailabilityRepository();
    }

    private function checkAuth(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            exit;
        }
        return $_SESSION['user'];
    }

    public function create(): void
    {
        $user = $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/sportif/coaches');
            return;
        }

        $coachId = (int)($_POST['coach_id'] ?? 0);
        $availabilityId = (int)($_POST['availability_id'] ?? 0);
        $sportifId = (int)$user['id'];

        if ($coachId === 0 || $availabilityId === 0) {
            $_SESSION['error'] = "Invalid booking information.";
            $this->redirect('/sportif/coaches');
            return;
        }

        
        $statusId = $this->reservationRepo->getStatusIdByName('pending');

        
        $coachProfile = $this->coachRepo->find($coachId); 

        $price = 50.00; // Default
        if ($coachProfile) {
            $price = $coachProfile->getHourlyRate();
        }

        $success = $this->reservationRepo->create([
            'sportif_id' => $sportifId,
            'coach_id' => $coachId,
            'availability_id' => $availabilityId,
            'status_id' => $statusId,
            'price' => $price
        ]);

        if ($success) {
            // Update availability to unavailable
            $this->availabilityRepo->updateStatus($availabilityId, false);

            $_SESSION['success'] = "Session booked successfully!";
            $this->redirect('/sportif/seances');
        } else {
            $_SESSION['error'] = "Failed to book session. Please try again.";
            $this->redirect('/sportif/coach/' . $coachId);
        }
    }

    public function updateStatus(): void
    {
        header('Content-Type: application/json');

        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check authentication without redirect
        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'coach') {
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            return;
        }

        $user = $_SESSION['user'];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

       
        $reservationId = (int)($input['id'] ?? 0);
        $action = $input['action'] ?? '';

        if ($reservationId === 0 || empty($action)) {
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
            return;
        }

        // Map action to status ID
        $statusMap = [
            'accept' => 2,    // confirmed
            'decline' => 4,   // cancelled
            'cancel' => 4     // cancelled
        ];

        if (!isset($statusMap[$action])) {
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            return;
        }

        $statusId = $statusMap[$action];

        
        $reservation = $this->reservationRepo->findById($reservationId);
        if (!$reservation) {
            echo json_encode(['success' => false, 'message' => 'Reservation not found']);
            return;
        }

        
        $coachProfile = $this->coachRepo->findByUserId((int)$user['id']);
        if (!$coachProfile) {
            echo json_encode(['success' => false, 'message' => 'Coach profile not found']);
            return;
        }

        if ($reservation['coach_id'] !== $coachProfile->getCoachId()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        // Update status
        $success = $this->reservationRepo->updateStatus($reservationId, $statusId);

        if ($success) {
            
            if ($action === 'decline' || $action === 'cancel') {
                $availabilityId = $reservation['availability_id'];
                $this->availabilityRepo->updateStatus($availabilityId, true);
            }
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
    }

    public function cancelBySportif(): void
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'sportif') {
            echo json_encode(['success' => false, 'message' => 'Not authenticated as sportif']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $reservationId = (int)($input['id'] ?? 0);

        if ($reservationId === 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
            return;
        }

        $reservation = $this->reservationRepo->findById($reservationId);

        if (!$reservation) {
            echo json_encode(['success' => false, 'message' => 'Reservation not found']);
            return;
        }

        if ($reservation['sportif_id'] !== (int)$_SESSION['user']['id']) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        // 4 = cancelled status
        $success = $this->reservationRepo->updateStatus($reservationId, 4);

        if ($success) {
            // Free up the availability
            $availabilityId = $reservation['availability_id'];
            $this->availabilityRepo->updateStatus($availabilityId, true);

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel reservation']);
        }
    }
}
