<?php

namespace Bradsi\Models;

class UserManager extends DbConnectionManager {

    /**
     * Login a user.
     * Returns true if login successful, false if error.
     *
     * @param $email
     * @param $pwd
     * @return bool
     */
    public function loginUser($email, $pwd): bool {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        $pwdMatch = password_verify($pwd, $row['password']);

        if ($pwdMatch) {
            $_SESSION["isLoggedIn"] = true;
            $_SESSION["fNameUser"] = $row['first_name'];
            $_SESSION["userId"] = $row['id'];
        }

        return $pwdMatch;
    }

    /**
     * Register a new user.
     * Returns true if user registered successfully, false if error.
     *
     * @param $fName
     * @param $lName
     * @param $email
     * @param $username
     * @param $pwd
     * @return bool
     */
    public function registerUser($fName, $lName, $email, $username, $pwd): bool {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if ($this->isValueDuplicate('email', $email)) return false;
        if ($this->isValueDuplicate('password', $pwd)) return false;

        $sql = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?);";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $email, $username, $hashedPwd]);

        return ($stmt->rowCount()) ? true : false;
    }

    /**
     * Check if email/password already exists in the db.
     * Returns true if duplicate, false if unique.
     *
     * @param string $column
     * @param string $value
     * @return bool
     */
    private function isValueDuplicate(string $column, string $value): bool {
        $sql = "SELECT ".$column." FROM users WHERE ".$column."=?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch();
    }
}