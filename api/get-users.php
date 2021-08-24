<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-ALlow-Methods: POST");

require_once $_SERVER['DOCUMENT_ROOT']. '/system/vendor/autoload.php';

use Core\UserController;
use Includes\Database;

$db = new Database();

$user = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $page = (int) htmlspecialchars(strip_tags($_GET['page']));
    $row_per_page = 4;

    $table_name = "users";

    if(!empty($page) && is_int($page)){
        try {
            $data = $user->fetchData($page, $row_per_page, $table_name);
            $paginate = $user->createPaginateLinks($table_name, $row_per_page);
    
            if($data){
                http_response_code(200);
                echo json_encode(["status"=>true,"data" => $data, "paginate" => $paginate]);
            }else{
                http_response_code(400);
                echo json_encode(["status"=>false,"message" => "No user found"]);
            }
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["status"=>false,"message" => "Invalid page parameter"]);
        }
    }else{
        http_response_code(400);
        echo json_encode(["status"=>false,"message" => "No pages"]);
    }
    
} else {
    http_response_code(503);
    echo json_encode(["status"=>false,"message" => "Access denied"]);
}

