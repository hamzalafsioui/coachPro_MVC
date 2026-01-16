<?php

declare(strict_types=1);

namespace App\Controllers;

use Controller;

class HomeController extends Controller
{

    public function home(): void
    {
        $this->renderWithLayout('home');
    }
}
