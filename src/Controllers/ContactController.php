<?php
namespace Bradsi\Controllers;

$upTwo = dirname(__DIR__, 2);
require $upTwo . '/vendor/autoload.php';

use Bradsi\Models\ContactManager;
use JetBrains\PhpStorm\NoReturn;
use League\Plates\Engine;


class ContactController {
    private Engine $templates;
    private ContactManager $cm;

    public function __construct(){
        $this->templates = new Engine('../src/Views/');
        $this->cm = new ContactManager();
    }

    #[NoReturn] public function create($request): void {
        $fName = $request['fName'];
        $lName = $request['lName'];

        $creationSuccessful = $this->cm->createContact($fName, $lName);
        if ($creationSuccessful) {
            exit(header("Location: ../dashboard"));
        }

        echo $this->templates->render('contacts/new-contact', [
            'error' => 'An unexpected error occurred.'
        ]);
    }

    public function readAll() {
        $contacts = $this->cm->getAllContactsById();

        echo $this->templates->render('dashboard', [
            'name' => $_SESSION["fNameUser"],
            'contacts' => $contacts
        ]);
    }

    #[NoReturn] public function editContact($request) {
        $id = $request['contactId'];
        $fName = $request['fName'];
        $lName = $request['lName'];

        $this->cm->editContactById($id, $fName, $lName);
    }

    #[NoReturn] public function deleteContact($request){
        $id = $request['contactId'];

        $deleteSuccessful = $this->cm->deleteContactById($id);
        if ($deleteSuccessful) {
            exit(header("Location: ../dashboard"));
        }
    }
}