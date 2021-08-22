<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-ALlow-Methods: POST");

require_once $_SERVER['DOCUMENT_ROOT']. '/system/vendor/autoload.php';

use Core\CartController;
use Includes\Database;
use Firebase\JWT\JWT;

\Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']. '/system')->load();

$db = new Database();

$cart = new CartController($db);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $headers = getallheaders();

    $food = htmlspecialchars(strip_tags($_POST['food_id']));
    $quantity = htmlspecialchars(strip_tags($_POST['quantity']));
    $price = htmlspecialchars(strip_tags($_POST['price']));

    if (!empty($food) && !empty($quantity) && !empty($price)) {
        try {
            $jwt = $headers['Authorization'];

            $secret_key = $_ENV['JWT_SECRET_KEY'];

            $decoded_data = JWT::decode($jwt, $secret_key, array('HS256'));
            
            if($cart->create_cart($decoded_data->data->id, $food, $quantity, $price)){
                http_response_code(200);
                echo json_encode(["status" => true, "message" => "Cart has been added"]);
            }else{
                http_response_code(400);
                echo json_encode(["status"=>false,"message" => "Failed to add cart"]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => true, "message" => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status"=>false,"message" => "Require all fields"]);
    }
} else {
    http_response_code(503);
    echo json_encode(["status"=>false,"message" => "Access denied"]);
}
