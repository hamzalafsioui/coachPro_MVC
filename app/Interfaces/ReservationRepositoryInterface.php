<?php

namespace App\Interfaces;

use App\Models\Reservation;

interface ReservationRepositoryInterface
{
    public function find(int $id): ?Reservation;
    public function create(array $data): bool;
    public function getCoachUpcomingSessions(int $coachId): array;
    public function getSportifUpcomingSessions(int $sportifId): array;
    // public function updateStatus(int $id, string $status): bool;
}
