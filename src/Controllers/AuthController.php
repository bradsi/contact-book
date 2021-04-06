<?php
namespace Bradsi\Controllers;

use Bradsi\Models\UserManager;
use JetBrains\PhpStorm\NoReturn;
use League\Plates\Engine;

class AuthController extends Helpers {
    private Engine $templates;

    public function __construct(){
        $this->templates = new Engine('../src/Views/');
    }

    #[NoReturn] public function register($request): void{
        $fName = $request['fName'];
        $lName = $request['lName'];
        $email = $request['email'];
        $username = $request['username'];
        $pwd = $request['password'];

        $um = new UserManager();
        $registerSuccessful = $um->registerUser($fName, $lName, $email, $username, $pwd);

        if ($registerSuccessful) {
            exit(header("Location: ../login"));
        } else {
            exit(header("Location: ../register"));
        }
    }

    #[NoReturn] public function login($request){
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

        $um = new UserManager();
        $loginSuccessful = $um->loginUser($loginEmail, $loginPwd);
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