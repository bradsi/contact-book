<?php

class AuthController {
    public function register(){
        echo 'Inside AuthController->register()';
        exit(header("Location: ../testing"));
    }

    public function login(){
        // ...
    }
}