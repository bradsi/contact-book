<?php

namespace Bradsi\Models;

class UserManager extends DbConnectionManager {

    /**
     * Login a user.
     * Returns true if login successful, returns error message if unsuccessful.
     *
     * @param $email
     * @param $pwd
     * @return bool|string
     */
    public function loginUser($email, $pwd): bool|string {
        if ($this->containsEmptyValues(array($email, $pwd))) return 'Please fill out the form completely.';
        if ($this->isEmailInvalid($email)) return 'Email provided is invalid.';
        if ($this->emailDoesNotExist($email)) return 'No account linked to the email provided.';
        if ($this->passwordIncorrect($email, $pwd)) return 'Password incorrect';

        $sql = "SELECT * FROM users WHERE email = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        $_SESSION["isLoggedIn"] = true;
        $_SESSION["fNameUser"] = $row['first_name'];
        $_SESSION["userId"] = $row['id'];

        return true;
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
     * @return bool|string
     */
    public function registerUser($fName, $lName, $email, $username, $pwd): bool|string {
        if ($this->containsEmptyValues(array($fName, $lName, $email, $username, $pwd)))
            return 'Please fill out the form completely.';
        if ($this->isEmailInvalid($email)) return 'Email provided is invalid.';
        if ($this->isValueDuplicate('email', $email)) return 'Account already linked to the email provided.';
        if ($this->isValueDuplicate('username', $username))
            return 'Account already linked to the username provided.';

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?);";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fName, $lName, $email, $username, $hashedPwd]);

        if ($stmt->rowCount()) return true;
        return 'An unexpected error occurred.';
    }

    /**
     * Check if email/username already exists in the db.
     * Returns true if duplicate, false if unique.
     *
     * @param string $column
     * @param string $value
     * @return bool
     */
    private function isValueDuplicate(string $column, string $value): bool {
        $sql = "SELECT " . $column . " FROM users WHERE " . $column . "=?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    private function containsEmptyValues($arr): bool {
        foreach ($arr as $value) {
            if (empty($value)) return true;
        }
        return false;
    }

    private function isEmailInvalid($email): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    private function emailDoesNotExist($email): bool {
        $sql = "SELECT email FROM users WHERE email = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if (!$stmt->rowCount()) {
            return true;
        }
        return false;
    }

    private function passwordIncorrect($email, $pwd): bool {
        $sql = "SELECT password FROM users WHERE email = ?;";
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        if (!password_verify($pwd, $row['password'])) {
            return true;
        }
        return false;
    }
}