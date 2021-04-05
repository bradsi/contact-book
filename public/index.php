<?php
$upOne = dirname(__DIR__, 1);
require $upOne . '/vendor/autoload.php';

session_start();

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Bradsi\Controllers\AuthController;
use Bradsi\Controllers\ContactController;
use Bradsi\Models\DbConnectionManager;

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

$controllerName = null;
$methodName = null;

$templates = new League\Plates\Engine('../src/Views/');

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
    case '/logout':
        $controllerName = AuthController::class;
        $methodName = 'logout';
        break;
    case '/dashboard':
        echo $templates->render('dashboard', [
            'name' => $_SESSION["fNameUser"]
        ]);
        break;
    case '/new-contact':
        echo $templates->render('contacts/new-contact');
        break;
    case 'newContact':
        $controllerName = ContactController::class;
        $methodName = 'create';
        break;
    case 'registerNewUser' :
        $logger->debug('inside switch case: registerNewUser');
        $controllerName = AuthController::class;
        $methodName = 'register';
        break;
    case 'loginUser':
        $logger->debug('inside switch case: loginUser');
        $controllerName = AuthController::class;
        $methodName = 'login';
        break;
    default:
        http_response_code(404);
        echo $templates->render('pages/404');
        break;
}

$db = new DbConnectionManager();
$dbConnection = null;
if ($db) $dbConnection = $db->connect();

if ($controllerName && $methodName) {
    $controller = new $controllerName();
    $controller->$methodName($_REQUEST);
}
