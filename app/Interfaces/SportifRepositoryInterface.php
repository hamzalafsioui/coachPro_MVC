<?php

namespace App\Interfaces;

use App\Models\Sportif;

interface SportifRepositoryInterface
{
    public function find(int $id): ?Sportif;
    public function create(array $data): bool;
    public function findByUserId(int $userId): ?Sportif;
    public function getStats(int $sportifId): array;
    public function getRecentActivity(int $sportifId): array;
    public function getWeeklyActivity(int $sportifId): array;
    public function getNextSession(int $sportifId): ?array;
}
