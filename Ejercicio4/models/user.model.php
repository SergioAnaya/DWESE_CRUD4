<?php

class User {

    private string $userId;
    private string $name;
    private string $lastnames;
    private string $username;
    private string $password;

    function __construct (string $name, string $lastnames, string $username, string $password) {
        $this -> name = $name;
        $this -> lastnames = $lastnames;
        $this -> username = $username;
        $this -> password = $password;
    }

    public function setUserId (string $id) {
        $this -> userId = $id;
    }

    public function getUserId (): string {
        return $this -> userId;
    }

    public function getName (): string {
        return $this -> name;
    }

    public function getLastnames (): string {
        return $this -> lastnames;
    }

    public function getUsername (): string {
        return $this -> username;
    }

    public function getPassword (): string {
        return $this -> password;
    }
}