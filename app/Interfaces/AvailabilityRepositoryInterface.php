<?php

namespace App\Interfaces;

use App\Models\Availability;

interface AvailabilityRepositoryInterface
{
    public function create(array $data): bool;
    public function getByCoachId(int $coachId): array;
    // public function delete(int $id): bool;
}
