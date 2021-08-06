<?php

declare(strict_types=1);

namespace Includes;

use PDO;
use PDOException;

class Database
{
    public $con;

    public function connect(): object
    {
        try {
            $this->con = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->con;
        } catch (PDOException $e) {
            return new PDOException($e->getMessage());
        }
    }
}
