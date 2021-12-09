<?php

require_once(realpath(dirname(__FILE__) . '/../../DBConn.php'));

class Database {

    function __construct () {
        $conn = new DBConn();
        $this -> conn = $conn -> getConn();
        $this -> createDatabase();
        $this -> createTableUsers();
        $this -> createTableUsersType();
        $this -> createTableBooks();
        $this -> createTableLoans();
        $this -> addForeignKeys();
    }

    private function useDatabase (string $database = 'db_library') {
        $sql = "USE " . $database;
        $this -> conn -> exec($sql);
    }

    private function createDatabase () {
        try {
            $sql = "DROP DATABASE IF EXISTS db_library";
            $this -> conn -> exec($sql);
            $sql = "CREATE DATABASE db_library";
            $this -> conn -> exec($sql);
            $log = 'Database DB_LIBRARY created successfully';
            $this -> console_log($log);
        } catch (PDOException $e) {
            $log = 'Database DB_LIBRARY has not been created correctly.' . "<br>" . $e -> getMessage() . '<br>';
            $this -> console_log($log);
        }
    }

    private function createTableUsers () {
        try {
            $this -> useDatabase();
            $sql = "DROP TABLE IF EXISTS users";
            $this -> conn -> exec($sql);
            $sql = "CREATE TABLE users (
                id_user INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(15) UNIQUE NOT NULL,
                password VARCHAR(50) NOT NULL,
                name VARCHAR(50) NOT NULL,
                lastnames VARCHAR(100) NOT NULL,
                cod_user_type INT(1) UNSIGNED)";
            $this -> conn -> exec($sql);
            $sql = "INSERT INTO users (name, lastnames, username, password, cod_user_type) VALUES ('Administrator', 'Administrator', 'admin', 'admin', 1)";
            $this -> conn -> exec($sql);
            $sql = "INSERT INTO users (name, lastnames, username, password, cod_user_type) VALUES ('Standard', 'Standard', 'standard', 'standard', 2)";
            $this -> conn -> exec($sql);
            $log = 'Table USERS created successfully';
            $this -> console_log($log);
        } catch (PDOException $e) {
            $log = 'Table USERS has not been created correctly.' . "<br>" . $e -> getMessage() . '<br>';
            $this -> console_log($log);
        }
    }

    private function createTableUsersType () {
        try {
            $this -> useDatabase();
            $sql = "DROP TABLE IF EXISTS users_type";
            $this -> conn -> exec($sql);
            $sql = "CREATE TABLE users_type (
                cod_user_type INT(1) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL)";
            $this -> conn -> exec($sql);
            $sql = "INSERT INTO users_type (name) VALUES ('Administrator')";
            $this -> conn -> exec($sql);
            $sql = "INSERT INTO users_type (name) VALUES ('Standard')";
            $this -> conn -> exec($sql);
            $log = 'Table USERS_TYPE created successfully';
            $this -> console_log($log);
        } catch (PDOException $e) {
            $log = 'Table USERS_TYPE has not been created correctly.' . "<br>" . $e -> getMessage() . '<br>';
            $this -> console_log($log);
        }
    }

    private function createTableBooks () {
        try {
            $this -> useDatabase();
            $sql = "DROP TABLE IF EXISTS books";
            $this -> conn -> exec($sql);
            $sql = "CREATE TABLE books (
                id_book INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                author VARCHAR(50) NOT NULL,
                editorial VARCHAR(50) NOT NULL)";
            $this -> conn -> exec($sql);
            $sql = "INSERT INTO books (title, author, editorial) VALUES ('Juego de tronos', 'George R. R. Martin', 'Ediciones Gigamesh'),
                ( 'Choque de reyes', 'George R. R. Martin', 'Ediciones Gigamesh'),
                ( 'Tormenta de espadas', 'George R. R. Martin', 'Ediciones Gigamesh'),
                ( 'Festín de cuervos', 'George R. R. Martin', 'Ediciones Gigamesh'),
                ( 'Danza de dragones', 'George R. R. Martin', 'Ediciones Gigamesh');";
            $this -> conn -> exec($sql);
            $log = 'Table BOOKS created successfully';
            $this -> console_log($log);
        } catch (PDOException $e) {
            $log = 'Table BOOKS has not been created correctly.' . "<br>" . $e -> getMessage() . '<br>';
            $this -> console_log($log);
        }
    }

    private function createTableLoans () {
        try {
            $this -> useDatabase();
            $sql = "DROP TABLE IF EXISTS loans";
            $this -> conn -> exec($sql);
            $sql = "CREATE TABLE loans (
                id_loans INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                id_user INT(11) UNSIGNED,
                id_book INT(11) UNSIGNED,
                loan_date DATE)";
            $this -> conn -> exec($sql);
            $log = 'Table LOANS created successfully';
            $this -> console_log($log);
        } catch (PDOException $e) {
            $log = 'Table LOANS has not been created correctly.' . "<br>" . $e -> getMessage() . '<br>';
            $this -> console_log($log);
        }
    }

    private function addForeignKeys () {
        try {
            $this -> useDatabase();
            $sql = "ALTER TABLE loans 
                ADD CONSTRAINT FK_USERS
                FOREIGN KEY (id_user)
                REFERENCES users (id_user)";
            $this -> conn -> exec($sql);
            $sql = "ALTER TABLE loans 
                ADD CONSTRAINT FK_BOOKS
                FOREIGN KEY (id_book)
                REFERENCES books (id_book)";
            $this -> conn -> exec($sql);
            $sql = "ALTER TABLE users 
                ADD CONSTRAINT FK_USERS_TYPE
                FOREIGN KEY (cod_user_type)
                REFERENCES users_type (cod_user_type)";
            $this -> conn -> exec($sql);
            $log = 'FKs created successfully';
            $this -> console_log($log);
        } catch (PDOException $e) {
            $log = 'FKs has not been created correctly.' . "<br>" . $e -> getMessage() . '<br>';
            $this -> console_log($log);
        }

    }

    private function console_log ($log) {
        echo '<script>';
        echo 'console.log('. json_encode($log) .')';
        echo '</script>';
    }
}