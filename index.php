<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__. '/core/HomeController.php';
use Core\HomeController;
use Core\View\Route;

$router = new AltoRouter();

$router->setBasePath('/system');

// Routing
$router->map('GET', '/', 'HomeController#index');
$router->map('GET', '/about', 'HomeController#about');

$router->map('GET', '/order', function () {
    require __DIR__ . '/views/order.php';
});

$match = $router->match();

if ($match === false) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    exit;
}

if (is_string($match['target'])) {
    list($controller, $action) = explode('#', $match['target']) ;
}

// call closure or throw 404 status
if (is_string($match['target']) && is_callable($controller, $action)) {
    $obj = new $controller(new Route());
    call_user_func_array(array($obj,$action), array($match['params']));
} elseif (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
