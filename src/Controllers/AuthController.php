<?php
namespace Bradsi\Controllers;

class AuthController {
    public function register(){
        echo 'Inside AuthController->register()';
        exit(header("Location: ../testing-register"));
    }

    public function login(){
        echo 'Inside AuthController->login()';
        exit(header("Location: ../testing-login"));
    }
}