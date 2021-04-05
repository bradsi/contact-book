<?php
namespace Bradsi\Models;

use JetBrains\PhpStorm\NoReturn;
use PDO;

class DbConnectionManager {
    private $host;
    private $user;
    private $pass;
    private $db;

    public function __construct() {
        $ini = parse_ini_file('../config.ini');
        $this->host = $ini['db_host'];
        $this->user = $ini['db_user'];
        $this->pass = $ini['db_pass'];
        $this->db = $ini['db_name'];
    }

    public function connect(): PDO {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
        $pdo = new PDO($dsn, $this->user, $this->pass);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }

    /*
     * Authentication
     */
    public function loginUser($email, $pwd): bool {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        // Verify password
        $pwdMatch = password_verify($pwd, $row['password']);

        if ($pwdMatch) {
            $_SESSION["isLoggedIn"] = true;
            $_SESSION["fNameUser"] = $row['first_name'];
            $_SESSION["userId"] = $row['id'];
            return true;
        } else {
            return false;
        }
    }

    public function registerUser($fName, $lName, $email, $username, $pwd): bool {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        $usernameCheck = $this->checkUsernameUnique($username);
        $emailCheck = $this->checkEmailUnique($email);

        if (!$usernameCheck || !$emailCheck) {
            return false;
        }

        $sql = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?);";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $email, $username, $hashedPwd]);
        $registerSuccess = $stmt->rowCount();

        if ($registerSuccess) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Contacts
     */
    public function createContact($fName, $lName): bool {
        $userId = $_SESSION['userId'];

        $sql = "INSERT INTO contacts (first_name, last_name, user_id) VALUES (?, ?, ?);";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $userId]);
        $created = $stmt->rowCount();

        return $created ? true: false;
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
            exit(header("Location: ../dashboard.php"));
        } else {
            exit(header("Location: ../dashboard.php"));
        }
    }

    /*
     * Helpers
     */
    private function checkUsernameUnique($username): bool {
        $sql = "SELECT username FROM users WHERE username=?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);

        return !$stmt->fetch();
    }

    // Refactor according to DRY
    private function checkEmailUnique($email): bool {
        $sql = "SELECT email FROM users WHERE email=?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        return !$stmt->fetch();
    }
}