<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    protected ?int $id = null;
    protected string $firstname = '';
    protected string $lastname = '';
    protected string $email = '';
    protected ?string $phone = null;
    protected int $role_id = 0;
    protected ?string $created_at = null;
    protected ?string $updated_at = null;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getRoleId(): int
    {
        return $this->role_id;
    }
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
    public function setRoleId(int $role_id): void
    {
        $this->role_id = $role_id;
    }
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }
    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
