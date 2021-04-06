<?php
namespace Bradsi\Controllers;

$upTwo = dirname(__DIR__, 2);
require $upTwo . '/vendor/autoload.php';

use Bradsi\Models\ContactManager;
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

        $cm = new ContactManager();
        $creationSuccessful = $cm->createContact($fName, $lName);

        if ($creationSuccessful) {
            exit(header("Location: ../dashboard"));
        } else {
            exit(header("Location: ../new-contact"));
        }
    }

    public function readAll() {
        $cm = new ContactManager();
        $posts = $cm->getAllContactsById();

        echo $this->templates->render('dashboard', [
            'name' => $_SESSION["fNameUser"],
            'posts' => $posts
        ]);
    }

    #[NoReturn] public function editContact($request) {
        $id = $request['contactId'];
        $fName = $request['fName'];
        $lName = $request['lName'];

        $cm = new ContactManager();
        $cm->editContactById($id, $fName, $lName);
    }

    #[NoReturn] public function deleteContact($request){
        $id = $request['contactId'];

        $cm = new ContactManager();
        $deleteSuccessful = $cm->deleteContactById($id);

        if ($deleteSuccessful) {
            exit(header("Location: ../dashboard"));
        } else {
            exit(header("Location: ../new-contact?msg=delete-error"));
        }
    }
}