<?php

declare(strict_types=1);

namespace App\Models;

class Review
{
    private ?int $id = null;
    private int $reservation_id;
    private int $author_id;
    private int $rating;
    private string $comment = '';
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
    
}
