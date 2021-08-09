<?php

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

// require_once "../vendor/autoload.php";

// use Core\HomeController;

// $home = new HomeController();

// /**
//  * @the condition is data from the ajax
//  */
// if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password'])) {
//     if ($home->registerUser(trim(htmlspecialchars($_POST['fname'])), trim(htmlspecialchars($_POST['lname'])), trim(htmlspecialchars($_POST['email'])), trim(htmlspecialchars($_POST['password'])))) {
//         echo json_encode(["status"=>true,"message" => "Successfully created student"]);
//     } else {
//         echo json_encode(["status"=>false,"message" => "Failed to create student"]);
//     }
// } else {
//     echo json_encode(["status"=>false,"message" => "Unable to access this page"]);
// }
