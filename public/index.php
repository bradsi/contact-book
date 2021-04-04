<?php
$upOne = dirname(__DIR__, 1);
require $upOne . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Bradsi\AuthController;

// create logger
$logger = new Logger('app');
$logger->pushHandler(new StreamHandler('../app.log', Logger::DEBUG));

$request = $_SERVER['REQUEST_URI'];
if (isset($_GET['action'])) {
    $request = $_GET['action'];
    $logger->debug('action is set, value: ' . $request);
} else {
    $logger->debug('action is not set, value: ' . $request);
}


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
    case '/register' :
        echo $templates->render('auth/register');
        break;
    case '/login' :
        echo $templates->render('auth/login');
        break;
    case 'registerNewUser' :
        $logger->debug('inside switch case: registerNewUser');
        $controller = new AuthController();
        $controller->register();
        break;
    default:
        http_response_code(404);
        echo $templates->render('pages/404');
        break;
}