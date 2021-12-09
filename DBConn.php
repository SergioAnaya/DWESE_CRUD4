<?php
    include_once 'DBConfig.php';

    class DBConn {

        private PDO $conn;

        function __construct () {
            try {
                $this -> conn = new PDO("mysql:host=" . servername . ";", user, password);
                $this -> conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully";
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage() . '<br>';
            }
        }

        function getConn (): PDO {
            return $this -> conn;
        }
    }