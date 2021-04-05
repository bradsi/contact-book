<?php
namespace Bradsi\Controllers;

$upOne = dirname(__DIR__, 2);
require $upOne . '/vendor/autoload.php';

use Bradsi\Models\DbConnectionManager;
use JetBrains\PhpStorm\NoReturn;
use League\Plates\Engine;


class ContactController {
    private Engine $templates;

    public function __construct(){
        $this->templates = new Engine('../src/Views/');
    }

    #[NoReturn] public function create($request): void {
        $fName = $request['fName'];
        $lName = $request['lName'];

        $db = new DbConnectionManager();
        $creationSuccessful = $db->createContact($fName, $lName);

        if ($creationSuccessful) {
            exit(header("Location: ../dashboard"));
        } else {
            exit(header("Location: ../new-contact"));
        }
    }

    public function readAll() {
        $db = new DbConnectionManager();
        $posts = $db->getAllContactsById();

        echo $this->templates->render('dashboard', [
            'name' => $_SESSION["fNameUser"],
            'posts' => $posts
        ]);
    }
}