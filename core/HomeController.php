<?php

declare(strict_types=1);

namespace Core;

class HomeController
{

    private array $errors;

    /**
     * @custom view but in the further development plan to create a different 
     */
    public function index(): void
    {
        require_once __DIR__. "/../views/home.php";
        exit;
    }

    public function registerView(): void
    {
        require_once __DIR__. "/../views/signup.php";
        exit;
    }

    public function registerUser(): bool
    {

        $auth = new AuthController($_REQUEST['first_name'], $_REQUEST['last_name'], $_REQUEST['email'], $_REQUEST['password']);
        
        if($auth->validateFirstName() == "first_name_number_validation"){
            $this->errors[] .= $auth->validateFirstName();
        }

        if($auth->validateLastName() == "last_name_number_validation"){
            $this->errors[] .= $auth->validateFirstName();
        }

        if($auth->validateEmail() == "email_format_validation"){
            $this->errors[] .= $auth->validateFirstName();
        }

        if($auth->validateEmail() == "password_len_validation"){
            $this->errors[] .= $auth->validateFirstName();
        }

        if($auth->createUser() == true){
            return true;
        }else{
            return false;
        }



    }


}