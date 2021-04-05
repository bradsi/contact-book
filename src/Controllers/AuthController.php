<?php
namespace Bradsi\Controllers;

use Bradsi\Models\DbConnectionManager;
use JetBrains\PhpStorm\NoReturn;

class AuthController {
    #[NoReturn] public function register($request): void{
        $fName = $request['fName'];
        $lName = $request['lName'];
        $email = $request['email'];
        $username = $request['username'];
        $pwd = $request['password'];

        $db = new DbConnectionManager();
        $registerSuccessful = $db->registerUser($fName, $lName, $email, $username, $pwd);

        if ($registerSuccessful) {
            exit(header("Location: ../login"));
        } else {
            exit(header("Location: ../register"));
        }
    }

    #[NoReturn] public function login($request): void{
        $loginEmail = $request['email'];
        $loginPwd = $request['password'];
        $db = new DbConnectionManager();
        $loginSuccessful = $db->loginUser($loginEmail, $loginPwd);
        if ($loginSuccessful) {
            exit(header("Location: ../dashboard"));
        } else {
            exit(header("Location: ../login"));
        }
    }

    #[NoReturn] public function logout(): void{
        $_SESSION = array();
        session_destroy();
        exit(header("Location: ../"));
    }
}