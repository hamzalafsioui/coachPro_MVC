<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\Database;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->mapToUser($data);
        }

        return null;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT u.*, r.name as role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->mapToUser($data);
        }

        return null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (firstname, lastname, email, password, role_id, phone, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");

        return $stmt->execute([
            $data['firstname'],
            $data['lastname'],
            $data['email'],
            $data['password'],
            $data['role_id'],
            $data['phone'] ?? null
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $values = [];

        if (isset($data['firstname'])) {
            $fields[] = 'firstname = ?';
            $values[] = $data['firstname'];
        }
        if (isset($data['lastname'])) {
            $fields[] = 'lastname = ?';
            $values[] = $data['lastname'];
        }
        if (isset($data['email'])) {
            $fields[] = 'email = ?';
            $values[] = $data['email'];
        }
        if (isset($data['phone'])) {
            $fields[] = 'phone = ?';
            $values[] = $data['phone'];
        }
        if (isset($data['password'])) {
            $fields[] = 'password = ?';
            $values[] = $data['password'];
        }
        if (isset($data['role_id'])) {
            $fields[] = 'role_id = ?';
            $values[] = $data['role_id'];
        }

        if (empty($fields)) {
            return false;
        }

        $fields[] = 'updated_at = NOW()';
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $values[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function getUserWithRole(string $email): ?array
    {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.email = ?
        ");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function getRoleIdByName(string $roleName): ?int
    {
        $stmt = $this->db->prepare("SELECT id FROM roles WHERE name = ?");
        $stmt->execute([$roleName]);
        $role = $stmt->fetch();

        if ($role) {
            return (int)$role['id'];
        }

        // Create if not exists
        $stmt = $this->db->prepare("INSERT INTO roles (name) VALUES (?)");
        if ($stmt->execute([$roleName])) {
            return (int)$this->db->lastInsertId();
        }

        return null;
    }

    public function getLastInsertId(): int
    {
        return (int)$this->db->lastInsertId();
    }

    private function mapToUser(array $data): User
    {
        $user = new User();
        $user->setId((int)$data['id']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setEmail($data['email']);
        $user->setPhone($data['phone'] ?? null);
        $user->setRoleId((int)$data['role_id']);
        // no password
        return $user;
    }
}
