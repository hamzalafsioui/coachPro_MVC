<?php

declare(strict_types=1);

namespace App\Models;

class Availability
{
    private ?int $id = null;
    private int $coach_id;
    private string $date = '';
    private string $start_time = '';
    private string $end_time = '';
    private bool $is_available = true;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCoachId(): int
    {
        return $this->coach_id;
    }
    public function getDate(): string
    {
        return $this->date;
    }
    public function getStartTime(): string
    {
        return $this->start_time;
    }
    public function getEndTime(): string
    {
        return $this->end_time;
    }
    public function isAvailable(): bool
    {
        return $this->is_available;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setCoachId(int $coachId): void
    {
        $this->coach_id = $coachId;
    }
    public function setDate(string $date): void
    {
        $this->date = $date;
    }
    public function setStartTime(string $startTime): void
    {
        $this->start_time = $startTime;
    }
    public function setEndTime(string $endTime): void
    {
        $this->end_time = $endTime;
    }
    public function setIsAvailable(bool $isAvailable): void
    {
        $this->is_available = $isAvailable;
    }
}
