<?php

namespace Bradsi\Models;

class UserManager extends DbConnectionManager {

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

        return ($registerSuccess) ? true : false;
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