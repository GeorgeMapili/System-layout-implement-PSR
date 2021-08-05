<?php

declare(strict_types=1);

namespace Core;
\session_start();

use Includes\Database;
use Ramsey\Uuid\Uuid;

class AuthController extends Database
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

        if(preg_match('~[0-9]+~', $this->first_name))
        {
            return 'first_name_number_validation';
        }
        
        return '';

    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validateLastName(): string
    {

        if(preg_match('~[0-9]+~', $this->last_name))
        {
            return 'last_name_number_validation';
        }
        
        return '';

    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validateEmail(): string
    {

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            return 'email_format_validation';
        }

        return '';

    }

    /**
     * @return string which stores into the array to printout the validations
     */
    public function validatePassword(): string
    {

        if(strlen($this->password) < 5)
        {
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

    /**
     * @return bool true if the user successfully created else return false
     */
    public function createUser(): bool
    {

        $uuid = Uuid::uuid4();

        $sql = "INSERT INTO users(user_id, user_first_name, user_last_name,user_email,user_password)VALUES(:uid,:first,:last,:email,:password)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':uid',$uuid->toString());
        $stmt->bindValue(':first', $this->first_name);
        $stmt->bindValue(':last', $this->last_name);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':password',$this->password);

        if($stmt->execute())
        {
            return true;
        }else{
            return false;
        }

    }

    /**
     * @Authenticate the user then redirect to the home page if success
     */
    public function loginUser()
    {

        $sql = "SELECT * FROM users WHERE user_email = :email";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":email", $this->email);
        $result = $stmt->execute();

        if($result)
        {

            while($user = $stmt->fetch(PDO::FETCH_ASSOC)){

                if(\password_verify($this->password,$user['user_passwowrd'])){

                    $_SESSION['user_info'] = $user;
                    // Redirect to home page
                    header("location:");
                    exit;
                }

            }

        }else{
            return false;
        }

    }

}