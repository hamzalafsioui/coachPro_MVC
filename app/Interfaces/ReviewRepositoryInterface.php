<?php

namespace App\Interfaces;

interface ReviewRepositoryInterface
{
    public function getCoachReviews(int $coachId): array;
    public function create(int $reservationId, int $authorId, int $rating, string $comment): bool;
    public function hasReview(int $reservationId): bool;
    public function addReply(int $reviewId, int $coachId, string $replyText): bool;
    public function getCoachReviewStats(int $coachId): array;
}
