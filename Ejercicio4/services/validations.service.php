<?php

require_once(realpath(dirname(__FILE__) . '/../services/user-crud.service.php'));
require_once(realpath(dirname(__FILE__) . '/../services/loan-crud.service.php'));

class Validations {

    private userCrud $userCrud;
    private loanCrud  $loanCrud;
    private bool $isValid = true;
    private array $errors;

    function __construct () {
        $this -> userCrud = new userCrud();
        $this -> loanCrud = new loanCrud();
    }

    function test_input ($data): string {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    private function isValidName () {
        if (empty($_POST['name'])) {
            $this -> errors['name'] = 'You must enter a name.';
            $this -> isValid = false;
        } else {
            $name = $this -> test_input($_POST['name']);
            if (!preg_match('/^[a-zñ][a-zñ ]{2,254}$/i', $name)) {
                $this -> errors['name'] = 'You must enter a valid name.';
                $this -> isValid = false;
            } else $this -> errors['name'] = '';
        }
    }

    private function isValidLastnames () {
        if (empty($_POST['lastnames'])) {
            $this -> errors['lastnames'] = 'You must enter a lastnames.';
            $this -> isValid = false;
        } else {
            $lastnames = $this -> test_input($_POST['lastnames']);
            if (!preg_match('/^[a-zñ][a-zñ ]{2,254}$/i', $lastnames)) {
                $this -> errors['lastnames'] = 'You must enter a valid lastnames.';
                $this -> isValid = false;
            } else $this -> errors['lastnames'] = '';
        }
    }

    /**
     * TODO: Refactor this
     *
     * Duplicate code.
     */

    /*private function isValidUsername () {
        if (empty($_POST['username'])) {
            $this -> errors['username'] = 'You must enter a username.';
            $this -> isValid = false;
        } else $this -> errors['username'] = '';
    }*/

    private function isValidUsernameLogin () {
        if (empty($_POST['username'])) {
            $this -> errors['username'] = 'You must enter a username.';
            $this -> isValid = false;
        } else {
            $username = $this -> test_input($_POST['username']);
            if ($this -> userCrud -> checkUsername($username) !== $username) {
                $this -> errors['username'] = 'The user does not exists.';
                $this -> isValid = false;
            } else $this -> errors['username'] = '';
        }
    }

    private function isValidUsernameRegister () {
        if (empty($_POST['username'])) {
            $this -> errors['username'] = 'You must enter a username.';
            $this -> isValid = false;
        } else {
            $username = $this -> test_input($_POST['username']);
            if ($this -> userCrud -> checkUsername($username) === $username) {
                $this -> errors['username'] = 'The user already exists.';
                $this -> isValid = false;
            } else $this -> errors['username'] = '';
        }
    }

    /**
     * TODO: Same as Username
     */

    /*function checkPasswordMatch () {
        $password = $this -> test_input($_POST['password']);
        if ($this -> userCrud -> checkPasswordMatch($_POST['username']) !== $password) {
            $this -> errors['password'] = 'Password is not correct.';
            $this -> isValid = false;
        } else $this -> errors['password'] = '';
    }*/

    private function isValidPasswordLogin () {
        if (empty($_POST['password'])) {
            $this -> errors['password'] = 'You must enter a password.';
            $this -> isValid = false;
        } else {
            $password = $this -> test_input($_POST['password']);
            if ($this -> userCrud -> checkPasswordMatch($_POST['username']) !== $password) {
                $this -> errors['password'] = 'Password is not correct.';
                $this -> isValid = false;
            } else $this -> errors['password'] = '';
        }
    }

    private function isValidPasswordRegister () {
        if (empty($_POST['password'])) {
            $this -> errors['password'] = 'You must enter a password.';
            $this -> isValid = false;
        } else $this -> errors['password'] = '';
    }

    private function bookAvailability (string $bookId) {
        if ($this -> loanCrud -> bookAvailability($bookId) == 1) {
            $this -> errors['bookAvailability'] = 'This book is not available.';
            $this -> isValid = false;
        } else $this -> errors['bookAvailability'] = '';
    }

    /**
     * TODO: Refactor this
     *
     * You need that call order so that the error messages are output in the correct order.
     */

    public function isValidLogin (): bool {
        $this -> isValidUsernameLogin();
        $this -> isValidPasswordLogin();
        return $this -> isValid;
    }

    public function isValidRegister (): bool {
        $this -> isValidName();
        $this -> isValidLastnames();
        $this -> isValidUsernameRegister();
        $this -> isValidPasswordRegister();
        return $this -> isValid;
    }

    public function isValidLoan (string $bookId): bool {
        $this -> isValidUsernameLogin();
        $this -> bookAvailability($bookId);
        return $this -> isValid;
    }

    public function getErrors(): array {
        return $this -> errors;
    }
}