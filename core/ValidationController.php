<?php

declare(strict_types=1);

namespace Core;

class ValidationController
{
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;

    public function __construct(string $first_name, string $last_name, string $email, string $password)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validateFirstName(): string
    {
        if (preg_match('~[0-9]+~', $this->first_name)) {
            return 'first_name_number_validation';
        }
        
        return '';
    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validateLastName(): string
    {
        if (preg_match('~[0-9]+~', $this->last_name)) {
            return 'last_name_number_validation';
        }
        
        return '';
    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validateEmail(): string
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return 'email_format_validation';
        }

        return '';
    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validatePassword(): string
    {
        if (strlen($this->password) < 5) {
            return 'password_len_validation';
        }

        return '';
    }

    /**
     * @return string where its already hashed the password
     */
    public function passwordHash(): string
    {
        $this->password = \password_hash($this->password, PASSWORD_DEFAULT);

        return $this->password;
    }

}
