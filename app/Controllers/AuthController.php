<?php

declare(strict_types=1);

namespace App\Controllers;

use Controller;
use App\Models\Auth;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function showLogin(): void
    {
        $this->render('auth.login');
    }

    public function showRegister(): void
    {
        $this->render('auth.register');
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please provide a valid email address.";
        }
        if (empty($password)) {
            $errors[] = "Password is required.";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' & ', $errors);
            $this->redirect('/login');
            return;
        }

        $user = $this->userRepo->getUserWithRole($email);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $role = $user['role_name'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;
            $_SESSION['user'] = [
                'id' => $user['id'],
                'role_id' => $user['role_id'],
                'role_name' => $role,
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'email' => $user['email']
            ];

            $_SESSION['success'] = "Login successful!";

            if ($role === 'coach') {
                $this->redirect('/coach/dashboard');
            } elseif ($role === 'sportif') {
                $this->redirect('/sportif/dashboard');
            } else {
                $this->redirect('/');
            }
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            $this->redirect('/login');
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
            return;
        }

        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'sportif';

        $errors = [];

        if (empty($firstname) || strlen($firstname) < 2) {
            $errors[] = "First name must be at least 2 characters long.";
        }
        if (empty($lastname) || strlen($lastname) < 2) {
            $errors[] = "Last name must be at least 2 characters long.";
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please provide a valid email address.";
        }
        if (empty($password) || strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }
        if (!in_array($role, ['sportif', 'coach'])) {
            $errors[] = "Invalid role selected.";
        }

        // Check if email exists
        if ($this->userRepo->findByEmail($email)) {
            $errors[] = "An account with this email already exists.";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode(' & ', $errors);
            $this->redirect('/register');
            return;
        }

        // Register Logic
        $roleId = $this->userRepo->getRoleIdByName($role);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userData = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hashedPassword,
            'role_id' => $roleId,
            'phone' => $phone
        ];

        if ($this->userRepo->create($userData)) {
            $userId = $this->userRepo->getLastInsertId();

            if ($role === 'coach') {
               
                $coachRepo = new \App\Repositories\CoachRepository();
                $coachRepo->create(['user_id' => $userId]);
            }

            $_SESSION['success'] = "Account created successfully! Please login.";
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = "An error occurred during registration.";
            $this->redirect('/register');
        }
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
