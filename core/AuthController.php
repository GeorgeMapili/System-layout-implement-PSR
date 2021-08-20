<?php

declare(strict_types=1);

namespace Core;

require_once($_SERVER['DOCUMENT_ROOT']. "/system/vendor/autoload.php");

\session_start();

use Includes\Database;
use Ramsey\Uuid\Uuid;
use PDO;

class AuthController
{
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private $database;
    private $errors = array();

    /**
     * @param string $first_name The string input first_name from the user
     * @param string $last_name The string input last_name from the user
     * @param string $email The string input email from the user
     * @param string $password The string input password from the user
     * @param Database Dependency injection to the db connection
     */
    public function __construct(?string $first_name, ?string $last_name, string $email, string $password, Database $db)
    {
        if (\is_null($first_name) && \is_null($last_name)):
            $this->email = self::sanitizeInput($email);
            $this->password = self::sanitizeInput($password);
            $this->database = $db; 
        else:
            $this->first_name = self::sanitizeInput($first_name);
            $this->last_name = self::sanitizeInput($last_name);
            $this->email = self::sanitizeInput($email);
            $this->password = self::sanitizeInput($password);
            $this->database = $db;
        endif;
    }

    /**
     * @return string Sanitize and Purify the user inputs
     */
    public static function sanitizeInput(string $input): string
    {
        return trim(\htmlspecialchars($input, ENT_QUOTES));
    }

    
    /**
     * @return string where its already hashed the password
     */
    public function passwordHash(): string
    {
        $this->password = \password_hash($this->password, PASSWORD_DEFAULT);

        return $this->password;
    }

    public function check_email(): bool
    {
        $query = "SELECT * FROM users WHERE email = :email";

        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool true when the user successfully created && false when something went wrong
     */
    public function createUser(): bool
    {
        $uuid = Uuid::uuid4();

        $sql = "INSERT INTO users(id, first_name, last_name, email, password)VALUES(:uid,:first,:last,:email,:password)";
        $stmt = $this->database->connect()->prepare($sql);
        $stmt->bindValue(':uid', $uuid->toString());
        $stmt->bindValue(':first', $this->first_name);
        $stmt->bindValue(':last', $this->last_name);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool true when the user then redirect to the home page if success
     * @return bool false when the user input incorrect credentials or something went wrong
     */
    public function loginUser()
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->database->connect()->prepare($sql);
        $stmt->bindValue(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (\password_verify($this->password, $user['password'])) {
                    $_SESSION['user_info'] = $user;
                    return $user;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * @param string first_name
     * @param string last_name
     * @param string email
     * @param string password
     * @return bool true or false
     */
    public function registerUser(): bool
    {
        $this->validation = new ValidationController($first_name, $last_name, $email, $password);
        
        if ($this->validation->validateFirstName() == "first_name_number_validation") {
            $this->errors[] = $this->validation->validateFirstName();
        }

        if ($this->validation->validateLastName() == "last_name_number_validation") {
            $this->errors[] = $this->validation->validateLastName();
        }

        if ($this->validation->validateEmail() == "email_format_validation") {
            $this->errors[] = $this->validation->validateEmail();
        }

        if ($this->validation->validatePassword() == "password_len_validation") {
            $this->errors[] = $this->validation->validatePassword();
        }

        if (empty($this->errors)) {
            $this->passwordHash();

            if ($this->createUser() === true) {
                return true;
            } else {
                return false;
            }
        } else {
            foreach ($this->errors as $data) {
                unset($this->errors[$data]);
            }

            return false;
        }
    }
}
