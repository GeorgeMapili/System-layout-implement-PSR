<?php

declare(strict_types=1);

namespace Core;

use Includes\Database;
use PDO;

class UserController
{

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @param int the page that is passed from the user input
     * @param int the row per page is a static value from the system
     */
    public function fetchData(int $page, int $row_per_page, string $table_name)
    {
        $begin = ($page - 1) * $row_per_page;

        $query = "SELECT * FROM $table_name LIMIT :begin, :row_per_page";
        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(":begin", $begin, PDO::PARAM_INT);
        $stmt->bindParam(":row_per_page", $row_per_page, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }

        if(count($data) > 0){
            return $data;
        }else{
            return false;
        }
    }


    public function createPaginateLinks(string $table_name, string $row_per_page)
    {
        $query = "SELECT * FROM $table_name";

        $stmt = $this->db->connect()->prepare($query);

        if($stmt->execute()){
            $users = $stmt->rowCount();

            $number_of_pages = ceil($users/$row_per_page);

            return $number_of_pages;
        }else{
            return false;
        }
    }
}