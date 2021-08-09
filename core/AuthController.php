<?php

declare(strict_types=1);

namespace Core;

\session_start();

use Includes\Database;
use Ramsey\Uuid\Uuid;

class AuthController
{
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private $database;

    /**
     * @param string $first_name The string input first_name from the user
     * @param string $last_name The string input last_name from the user
     * @param string $email The string input email from the user
     * @param string $password The string input password from the user
     * @param Database Dependency injection to the db connection
     */
    public function __construct(string $first_name, string $last_name, string $email, string $password, Database $db)
    {
        $this->first_name = self::sanitizeInput($first_name);
        $this->last_name = self::sanitizeInput($last_name);
        $this->email = self::sanitizeInput($email);
        $this->password = self::sanitizeInput($password);
        $this->database = $db;
    }

    /**
     * @return string Sanitize and Purify the user inputs
     */
    public static function sanitizeInput(string $input): string
    {
        return trim(\htmlspecialchars($input, ENT_QUOTES, UTF-8));
    }

    /**
     * @return bool true when the user successfully created
     * @return bool false when something went wrong
     */
    public function createUser(): bool
    {
        $uuid = Uuid::uuid4();

        $sql = "INSERT INTO users(user_id, user_first_name, user_last_name,user_email,user_password)VALUES(:uid,:first,:last,:email,:password)";
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
    public function loginUser(): bool
    {
        $sql = "SELECT * FROM users WHERE user_email = :email";
        $stmt = $this->database->connect()->prepare($sql);
        $stmt->bindValue(":email", $this->email);
        $result = $stmt->execute();

        if ($result) {
            while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (\password_verify($this->password, $user['user_passwowrd'])) {
                    $_SESSION['user_info'] = $user;
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
