<?php

declare(strict_types=1);

namespace Core;

use Includes\Database;

class HomeController
{
    private array $errors;
    private $auth;
    private $validation;

    /**
     * @custom view but in the further development plan to create a different
     */
    public function index(): void
    {
        // Handle views
    }

    /**
     * @custom view but in the further development plan to create a different
     */
    public function registerView(): void
    {
        // Handles views
    }

    /**
     * Initialize properties and dependency injection
     */
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
