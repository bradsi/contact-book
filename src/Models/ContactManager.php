<?php

namespace Bradsi\Models;

use JetBrains\PhpStorm\NoReturn;

class ContactManager extends DbConnectionManager {

    public function createContact($fName, $lName): bool {
        $userId = $_SESSION['userId'];

        $sql = "INSERT INTO contacts (first_name, last_name, user_id) VALUES (?, ?, ?);";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $userId]);
        $created = $stmt->rowCount();

        return $created ? true : false;
    }

    public function getAllContactsById(): array {
        $userId = $_SESSION['userId'];

        $sql = "SELECT * FROM contacts WHERE user_id = ? ORDER BY created_on DESC;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    public function deleteContactById($id): bool {
        $sql = "DELETE FROM contacts WHERE id = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $deleted = $stmt->rowCount();

        return $deleted ? true : false;
    }

    #[NoReturn] public function editContactById($id, $fName, $lName): void {
        $sql = "UPDATE contacts SET first_name = ?, last_name = ? WHERE id = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $id]);
        $edited = $stmt->rowCount();

        if ($edited) {
            exit(header("Location: ../dashboard"));
        } else {
            exit(header("Location: ../dashboard"));
        }
    }
}