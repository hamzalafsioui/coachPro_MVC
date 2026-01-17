<?php

/** @var Router $router */

$router->get('/', 'App\\Controllers\\HomeController@home');
$router->get('/home', 'App\\Controllers\\HomeController@home');

$router->get('/test', static function (): void {
    header('Content-Type: text/plain; charset=UTF-8');
    echo 'OK';
});

// Auth
$router->get('/login', 'App\\Controllers\\AuthController@showLogin');
$router->post('/login', 'App\\Controllers\\AuthController@login');
$router->get('/logout', 'App\\Controllers\\AuthController@logout');

$router->get('/register', 'App\\Controllers\\AuthController@showRegister');
$router->post('/register', 'App\\Controllers\\AuthController@register');

// Sportif pages
$router->get('/sportif/dashboard', 'App\\Controllers\\SportifController@dashboard');
$router->get('/sportif/coaches', 'App\\Controllers\\SportifController@coaches');
$router->get('/sportif/seances', 'App\\Controllers\\SportifController@seances');
$router->get('/sportif/history', 'App\\Controllers\\SportifController@history');
$router->get('/sportif/profile', 'App\\Controllers\\SportifController@profile');
$router->get('/sportif/coach/{id}', 'App\\Controllers\\SportifController@coachDetails');
$router->get('/sportif/coach_profile.php', function () use ($router) {
    $id = $_GET['id'] ?? 0;
    header("Location: " . BASE_URL . "/sportif/coach/" . $id);
    exit;
});

// Reservations
$router->post('/sportif/reservations/create', 'App\\Controllers\\ReservationController@create');
$router->post('/coach/reservations/update', 'App\\Controllers\\ReservationController@updateStatus');
$router->post('/sportif/reservations/cancel', 'App\\Controllers\\ReservationController@cancelBySportif');
$router->post('/sportif/reviews/create', 'App\\Controllers\\ReviewController@create');

// Coach pages
$router->get('/coach/dashboard', 'App\\Controllers\\CoachController@dashboard');
$router->get('/coach/profile', 'App\\Controllers\\CoachController@profile');
$router->get('/coach/reservations', 'App\\Controllers\\CoachController@reservations');
$router->get('/coach/seances', 'App\\Controllers\\CoachController@seances');
$router->get('/coach/availability', 'App\\Controllers\\CoachController@availability');
$router->post('/coach/availability', 'App\\Controllers\\CoachController@saveAvailability');
$router->get('/coach/clients', 'App\\Controllers\\CoachController@clients');
$router->get('/coach/reviews', 'App\\Controllers\\CoachController@reviews');
