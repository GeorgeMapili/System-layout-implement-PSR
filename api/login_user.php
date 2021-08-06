<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../vendor/autoload.php";

use Core\AuthController;
use Includes\Database;

$db = new Database();

/**
 * @the data from condition is from the ajax
 */
if (isset($_POST['email']) && isset($_POST['password'])) {
    $first_name = trim(htmlspecialchars($_POST['first']));
    $last_name = trim(htmlspecialchars($_POST['last']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    $auth = new AuthController($first_name, $last_name, $email, $password);

    if ($auth->loginUser()) {
        echo json_encode(["status"=>true,"message" => "Successfully authenticated"]);
    } else {
        echo json_encode(["status"=>false,"message" => "Something went wrong"]);
    }
} else {
    echo json_encode(["status"=>false,"message" => "Unable to access this page"]);
}
