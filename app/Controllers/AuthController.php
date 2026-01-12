<?php

declare(strict_types=1);

class AuthController extends Controller
{
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
        
        $this->redirect('/');
    }

    public function register(): void
    {
        
        $this->redirect('/login');
    }
}
