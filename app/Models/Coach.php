<?php

declare(strict_types=1);

namespace App\Models;

class Coach extends User
{
    private ?int $coach_id = null;
    private string $bio = '';
    private int $experience_years = 0;
    private string $certifications = '';
    private float $rating_avg = 0.0;
    private ?string $photo = null;
    private float $hourly_rate = 50.00;

    // Getters
    public function getCoachId(): ?int
    {
        return $this->coach_id;
    }
    public function getBio(): string
    {
        return $this->bio;
    }
    public function getExperienceYears(): int
    {
        return $this->experience_years;
    }
    public function getCertifications(): string
    {
        return $this->certifications;
    }
    public function getRatingAvg(): float
    {
        return $this->rating_avg;
    }
    public function getPhoto(): ?string
    {
        return $this->photo;
    }
    public function getHourlyRate(): float
    {
        return $this->hourly_rate;
    }

    // Setters
    public function setCoachId(int $id): void
    {
        $this->coach_id = $id;
    }
    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }
    public function setExperienceYears(int $years): void
    {
        $this->experience_years = $years;
    }
    public function setCertifications(string $cert): void
    {
        $this->certifications = $cert;
    }
    public function setRatingAvg(float $rating): void
    {
        $this->rating_avg = $rating;
    }
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }
    public function setHourlyRate(float $rate): void
    {
        $this->hourly_rate = $rate;
    }
}
