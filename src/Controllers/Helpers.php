<?php
namespace Bradsi\Controllers;

use JetBrains\PhpStorm\Pure;

class Helpers {
    /**
     * Returns true if any values in the array are empty.
     *
     * @param $array
     * @return bool
     */
    protected function hasEmptyValues($array): bool {
        foreach ($array as $value) {
            if (empty($value)) return true;
        }
        return false;
    }

    /**
     * Returns true if email is invalid.
     *
     * @param $email
     * @return bool
     */
    #[Pure] protected function emailInvalid($email): bool {
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Returns true if password is invalid.
     *
     * @param $password
     * @return bool
     */
    protected function passwordInvalid($password): bool {

    }
}