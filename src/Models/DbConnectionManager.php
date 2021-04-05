<?php
namespace Bradsi\Models;

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

    public function loginUser($email, $pwd): bool {
        $sql = "SELECT first_name, password FROM users WHERE email = ?;";
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