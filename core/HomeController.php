<?php

declare(strict_types=1);

namespace Core;

use Includes\Database;
use Core\View\Route;

class HomeController
{
    private array $errors;
    private $auth;
    private $validation;
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

    /**
     * @custom view but in the further development plan to create a different
     */
    public function registerView(): void
    {
        $this->router::view('register');
    }

    public function registerUser($first_name, $last_name, $email, $password): bool
    {
        $this->validation = new ValidationController($first_name, $last_name, $email, $password);
        
        if ($this->validation->validateFirstName() == "first_name_number_validation") {
            $this->errors[] .= $this->validation->validateFirstName();
        }

        if ($this->validation->validateLastName() == "last_name_number_validation") {
            $this->errors[] .= $this->validation->validateFirstName();
        }

        if ($this->validation->validateEmail() == "email_format_validation") {
            $this->errors[] .= $this->validation->validateFirstName();
        }

        if ($this->validation->validateEmail() == "password_len_validation") {
            $this->errors[] .= $this->validation->validateFirstName();
        }

        $this->auth = new AuthController($first_name, $last_name, $email, $password);

        if ($auth->createUser() == true) {
            return true;
        } else {
            return false;
        }
    }
}
