<?php
$upOne = dirname(__DIR__, 1);
require $upOne . '/vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

$templates = new League\Plates\Engine('../src/views/');

switch ($request) {
    case '/' :
    case '':
        echo $templates->render('pages/index', [
            'name' => 'Brad',
        ]);
        break;
    case '/about' :
        echo $templates->render('pages/about');
        break;
    default:
        http_response_code(404);
        echo $templates->render('pages/404');
        break;
}