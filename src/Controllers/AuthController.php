<?php
namespace Bradsi\Controllers;

use Bradsi\Models\UserManager;
use JetBrains\PhpStorm\NoReturn;
use League\Plates\Engine;

class AuthController {
    private Engine $templates;
    private UserManager $um;

    public function __construct(){
        $this->templates = new Engine('../src/Views/');
        $this->um = new UserManager();
    }

    #[NoReturn] public function register($request): void{
        $fName = $request['fName'];
        $lName = $request['lName'];
        $email = $request['email'];
        $username = $request['username'];
        $pwd = $request['password'];

        $registerResult = $this->um->registerUser($fName, $lName, $email, $username, $pwd);
        if ($registerResult === true) {
            echo $this->templates->render('auth/login', [
                'success' => 'Account registered successfully, you may now login.'
            ]);
            return;
        }

        echo $this->templates->render('auth/register', [
            'error' => $registerResult
        ]);
    }

    #[NoReturn] public function login($request): void {
        $loginEmail = $request['email'];
        $loginPwd = $request['password'];

        $loginResult = $this->um->loginUser($loginEmail, $loginPwd);
        if ($loginResult === true) {
            exit(header("Location: ../dashboard"));
        }

        echo $this->templates->render('auth/login', [
            'error' => $loginResult
        ]);
    }

    #[NoReturn] public function logout(): void {
        $_SESSION = array();
        session_destroy();
        echo $this->templates->render('pages/index');
    }
}