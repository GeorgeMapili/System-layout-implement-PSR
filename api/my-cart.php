<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-ALlow-Methods: GET");

require_once $_SERVER['DOCUMENT_ROOT']. '/system/vendor/autoload.php';

use Core\CartController;
use Includes\Database;
use Firebase\JWT\JWT;

$db = new Database();

$cart = new CartController($db);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $headers = getallheaders();

    try {
        $jwt = $headers['Authorization'];

        $secret_key = "owt125";
    
        $decoded_data = JWT::decode($jwt, $secret_key, array('HS256'));
    
        $my_carts = $cart->cart_list($decoded_data->data->id);

        if(!empty($my_carts)){
            http_response_code(200);
            echo json_encode(["status"=>true,"data" => $my_carts]);
        }else{
            http_response_code(400);
            echo json_encode(["status"=>true,"message" => "No carts found"]);
        }
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(["status"=>true,"message" => $e->getMessage()]);
    }
    
} else {
    http_response_code(503);
    echo json_encode(["status"=>false,"message" => "Access denied"]);
}
