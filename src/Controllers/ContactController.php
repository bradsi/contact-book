<?php
namespace Bradsi\Controllers;

use Bradsi\Models\DbConnectionManager;
use JetBrains\PhpStorm\NoReturn;

class ContactController {
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
}