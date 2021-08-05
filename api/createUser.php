<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../vendor/autoload.php";

use Core\HomeController;
use Includes\Database;

$db = new Database();
$home = new HomeController();

/**
 * @the condition is data from the ajax 
 */
if(isset($_POST['fname']))
{

    if($home->registerUser(trim(htmlspecialchars($_POST['fname'])), trim(htmlspecialchars($_POST['lname'])), trim(htmlspecialchars($_POST['email'])), trim(htmlspecialchars($_POST['password']))))
    {
        echo json_encode(["message" => "Successfully created student"]);
    }else{
        echo json_encode(["message" => "Failed to create student"]);
    }

}else{
    throw new Exception("You can't access this page!");
}