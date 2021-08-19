<?php

declare(strict_types=1);

namespace Core;

use Core\View\Route;

class HomeController
{
    private $router;

    public function __construct(Route $router)
    {
        $this->router = $router;
    }

    public function index()
    {
        $this->router::view('home');
    }

    public function about()
    {
        $this->router::view('about');
    }

    public function registerView()
    {
        $this->router::view('register');
    }

}
