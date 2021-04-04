<?php
$upOne = dirname(__DIR__, 1);
require $upOne . '/vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
    case '':
        require '../src/views/index.php';
        break;
    case '/about' :
        require '../src/views/about.php';
        break;
    default:
        http_response_code(404);
        require '../src/views/404.php';
        break;
}