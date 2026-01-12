<?php

declare(strict_types=1);

namespace App\Models;

class Reservation
{
    private ?int $id = null;
    private int $sportif_id;
    private int $coach_id;
    private int $availability_id;
    private int $status_id;
    private ?string $created_at = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSportifId(): int
    {
        return $this->sportif_id;
    }
    public function setSportifId(int $id): void
    {
        $this->sportif_id = $id;
    }

    public function getCoachId(): int
    {
        return $this->coach_id;
    }
    public function setCoachId(int $id): void
    {
        $this->coach_id = $id;
    }

    
}
