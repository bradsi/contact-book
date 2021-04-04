<?php
namespace Bradsi\Controllers;

use Bradsi\Models\DbConnectionManager;

class AuthController {
    public function register(){
        echo 'Inside AuthController->register()';
        exit(header("Location: ../testing-register"));
    }

    public function login($request){
        $loginEmail = $request['email'];
        $loginPwd = $request['password'];
        $db = new DbConnectionManager();
        $loginSuccessful = $db->loginUser($loginEmail, $loginPwd);
        if ($loginSuccessful) {
            exit(header("Location: ../dashboard"));
        }
    }
}