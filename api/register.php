<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once $_SERVER['DOCUMENT_ROOT']. '/system/vendor/autoload.php';

use Core\AuthController;
use Includes\Database;

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $first_name = trim(htmlspecialchars($_POST['first_name']));
    $last_name = trim(htmlspecialchars($_POST['last_name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    $auth = new AuthController($first_name, $last_name, $email, $password, $db);

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)) {
        if (!$auth->check_email()) {
            if ($auth->registerUser()) {
                http_response_code(200);
                echo json_encode(["status"=>true,"message" => "Successfully created student"]);
            } else {
                http_response_code(400);
                echo json_encode(["status"=>false,"message" => "Failed to create student"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["status"=>false,"message" => "Email already existed"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status"=>false,"message" => "Require all fields"]);
    }
} else {
    http_response_code(503);
    echo json_encode(["status"=>false,"message" => "Access denied"]);
}
