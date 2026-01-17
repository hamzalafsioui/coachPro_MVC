<?php

declare(strict_types=1);

namespace App\Controllers;

use Controller;
use App\Repositories\ReviewRepository;
use App\Models\Database;

class ReviewController extends Controller
{
    private ReviewRepository $reviewRepo;

    public function __construct()
    {
        $this->reviewRepo = new ReviewRepository();
    }

    private function checkAuth(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
            exit;
        }
        return $_SESSION['user'];
    }

    public function create(): void
    {
        header('Content-Type: application/json');

        $user = $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $reservationId = (int)($input['reservation_id'] ?? 0);
        $rating = (int)($input['rating'] ?? 0);
        $comment = trim($input['comment'] ?? '');

        if ($reservationId === 0 || $rating === 0 || empty($comment)) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            return;
        }

        if ($rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'message' => 'Invalid rating']);
            return;
        }

        $success = $this->reviewRepo->create($reservationId, (int)$user['id'], $rating, $comment);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Review submitted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit review. It may have already been reviewed or not completed.']);
        }
    }
}
