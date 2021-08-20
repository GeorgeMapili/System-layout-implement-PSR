<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

require_once $_SERVER['DOCUMENT_ROOT']. '/system/vendor/autoload.php';

use Core\AuthController;
use Includes\Database;
use Firebase\JWT\JWT;

$db = new Database();

/**
 * @the data from condition is from the ajax
 */
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $auth = new AuthController(null, null, $email, $password, $db);

        $data = $auth->loginUser();

        if ($data) {
            $iss = "localhost";
            $iat = time();
            $nbf = $iat+10;
            $exp = $iat+180;
            $aud = "myusers";
            $user_arr_data = array(
                "id" => $data['id']
            );

            $secret_key = "owt125";

            $payload_info = array(
                "iss" => $iss,
                "iat" => $iat,
                "nbf" => $nbf,
                "exp" => $exp,
                "aud" => $aud,
                "data" => $user_arr_data
            );

            $jwt = JWT::encode($payload_info, $secret_key);

            http_response_code(200);
            echo json_encode(["status"=>true, "jwt" => $jwt,"message" => "Successfully authenticated"]);
        } else {
            http_response_code(400);
            echo json_encode(["status"=>false,"message" => "Invalid Credentials/Something went wrong"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status"=>false,"message" => "Require all fields"]);
    }
} else {
    http_response_code(503);
    echo json_encode(["status"=>false,"message" => "Access Denied"]);
}
