<?php
$upOne = dirname(__DIR__, 1);
require $upOne . '/vendor/autoload.php';

session_start();

use Bradsi\Controllers\AuthController;
use Bradsi\Controllers\ContactController;

$request = $_SERVER['REQUEST_URI'];
if (isset($_GET['action'])) {
    $request = $_GET['action'];
    error_log('action is set, value: ' . $request);
} else {
    error_log('action is not set, value: ' . $request);
}

$controllerName = null;
$methodName = null;

$templates = new League\Plates\Engine('../src/Views/');

switch ($request) {
    case '/' :
    case '':
        echo $templates->render('pages/index');
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
        $controllerName = ContactController::class;
        $methodName = 'readAll';
        break;
    case 'deleteContact':
        $controllerName = ContactController::class;
        $methodName = 'deleteContact';
        break;
    case '/edit-contact':
        echo $templates->render('contacts/edit-contact', [
            'id' => $_REQUEST['contactId'],
            'fName' => $_REQUEST['fName'],
            'lName' => $_REQUEST['lName']
        ]);
        break;
    case 'editContact':
        $controllerName = ContactController::class;
        $methodName = 'editContact';
        break;
    case '/new-contact':
        echo $templates->render('contacts/new-contact');
        break;
    case 'newContact':
        $controllerName = ContactController::class;
        $methodName = 'create';
        break;
    case 'registerNewUser' :
        $controllerName = AuthController::class;
        $methodName = 'register';
        break;
    case 'loginUser':
        $controllerName = AuthController::class;
        $methodName = 'login';
        break;
    default:
        http_response_code(404);
        echo $templates->render('pages/404');
        break;
}

if ($controllerName && $methodName) {
    $controller = new $controllerName();
    $controller->$methodName($_REQUEST);
}