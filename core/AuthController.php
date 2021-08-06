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

    public function __construct(string $first_name, string $last_name, string $email, string $password, $db)
    {
        $this->first_name = trim(\htmlspecialchars($first_name));
        $this->last_name = trim(\htmlspecialchars($last_name));
        $this->email = trim(\htmlspecialchars($email));
        $this->password = trim(\htmlspecialchars($password));
        $this->database = $db;
    }

    /**
     * @return bool true if the user successfully created else return false
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
     * @Authenticate the user then redirect to the home page if success
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
                }else{
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
