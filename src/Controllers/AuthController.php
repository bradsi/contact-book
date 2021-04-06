<?php
namespace Bradsi\Controllers;

use Bradsi\Models\UserManager;
use JetBrains\PhpStorm\NoReturn;
use League\Plates\Engine;

class AuthController extends Helpers {
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

        $registerSuccessful = $this->um->registerUser($fName, $lName, $email, $username, $pwd);
        if ($registerSuccessful) {
            echo $this->templates->render('auth/login');
            return;
        }

        echo $this->templates->render('auth/register', [
            'error' => 'An unexpected error occurred.'
        ]);
    }

    #[NoReturn] public function login($request): void {
        $loginEmail = $request['email'];
        $loginPwd = $request['password'];

        /*
         * Error handling
         */
        if ($this->hasEmptyValues(array($loginEmail, $loginPwd))) {
            echo $this->templates->render('auth/login', [
                'error' => 'Please fill out the form completely.'
            ]);
            return;
        }

        if ($this->emailInvalid($loginEmail)) {
            echo $this->templates->render('auth/login', [
                'error' => 'The email is invalid.'
            ]);
            return;
        }

        $loginSuccessful = $this->um->loginUser($loginEmail, $loginPwd);
        if ($loginSuccessful) {
            exit(header("Location: ../dashboard"));
        }

        echo $this->templates->render('auth/login', [
            'error' => 'An unexpected error occurred.'
        ]);
    }

    #[NoReturn] public function logout(): void {
        $_SESSION = array();
        session_destroy();
        echo $this->templates->render('pages/index');
    }
}