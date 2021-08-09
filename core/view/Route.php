<?php

namespace Core\View;

class Route
{
    public static function view(string $route)
    {

        if (\file_exists(__DIR__ . "/../../views/"   .$route.".php")) {
            require_once __DIR__ . "/../../views/"   .$route.".php";
        }
    }
}
