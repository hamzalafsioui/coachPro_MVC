<?php

namespace App\Interfaces;

use App\Models\Coach;

interface CoachRepositoryInterface
{
    public function find(int $id): ?Coach;
    public function findByUserId(int $userId): ?Coach;
    public function create(array $data): ?int; 
    public function getAllCoaches(): array;
    public function getCoachStats(int $coachId): array;
}
