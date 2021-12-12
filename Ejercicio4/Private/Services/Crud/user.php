<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['db_connection'];
require_once $config['paths']['models']['user'];

class userCrud {

    private PDO $conn;

    function __construct () {
        $conn = new DBConn();
        $this -> conn = $conn -> getConn();
    }

    private function useDatabase (string $database = 'db_library') {
        $sql = "USE " . $database;
        $this -> conn -> exec($sql);
    }

    function createUser (User $user, int $codUserType) {
        try {
            $this -> useDatabase();
            $insert = $this -> conn -> prepare('INSERT INTO users (name, lastnames, username, password, cod_user_type) VALUES (:name, :lastnames, :username, :password, :codUserType)');
            $name = $user -> getName();
            $lastnames = $user -> getLastnames();
            $username = $user -> getUsername();
            $password = $user -> getPassword();
            $insert -> bindParam(':name', $name);
            $insert -> bindParam(':lastnames', $lastnames);
            $insert -> bindParam(':username', $username);
            $insert -> bindParam(':password', $password);
            $insert -> bindParam(':codUserType', $codUserType);
            $insert -> execute();
        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    }

    function updateUser (User $user, string $id) {
        try {
            $this -> useDatabase();
            $update = $this -> conn -> prepare('UPDATE users SET name = :name,
            lastnames = :lastnames, username = :username, password = :password WHERE id_user = :id');
            $name = $user -> getName();
            $lastnames = $user -> getLastnames();
            $username = $user -> getUsername();
            $password = $user -> getPassword();
            $update -> bindParam(':id', $id);
            $update -> bindParam(':name', $name);
            $update -> bindParam(':lastnames', $lastnames);
            $update -> bindParam(':username', $username);
            $update -> bindParam(':password', $password);
            $update -> execute();
        } catch (PDOException $e) {
            echo $update . "<br>" . $e -> getMessage();
        }
    }

    function deleteUser (string $username) {
        try {
            $this -> useDatabase();
            $delete = $this -> conn -> prepare('DELETE FROM users WHERE username = :username');
            $delete -> bindParam(':username', $username);
            $delete -> execute();
        } catch (PDOException $e) {
            echo $delete . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to count users. (Pagination)
     */

    private function countUsers () {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare("SELECT count(*) FROM users");
            $select -> execute();
            $users = $select -> fetchAll();
            return $users[0][0];
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to return the array of users per page. (Pagination)
     */

    private function usersByPage (int $page, int $per_page) {
        try {
            $this -> useDatabase();
            $select = "SELECT * FROM users LIMIT " . (($page - 1) * $per_page) . "," . $per_page;
            $select = $this -> conn -> prepare($select);
            $select -> execute();
            return $select -> fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    public function printUsersList () {
        $this -> useDatabase();
        if (array_key_exists('pg', $_GET)) {
            $page = $_GET['pg'];
        } else $page = 1;

        $limit = 2;
        $countOfUsers = $this -> countUsers();
        $max_num_pages = ceil($countOfUsers / $limit);

        foreach($this -> usersByPage($page, $limit) as $user) {
            echo '
                    <tr>
                    <td>' . $user -> name .'</td>
                    <td>' . $user -> lastnames .'</td>
                    <td>' . $user -> username .'</td>
                    <td>' . $user -> password .'</td>
                    <td><a href="users.php?username=' . $user -> username . '&action=delete"><i class="material-icons">delete</i></a></td>
                    <td><a href="index.php?username=' . $user -> username . '&action=edit"><i class="material-icons">edit</i></a></td>
                    </tr>';
        }
        for ($i = 0; $i < $max_num_pages; $i++) {
            echo '<span><a href="users.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a> - </span>';
        }
    }

    function checkUsername (string $username) {
        try {
            $this -> useDatabase();
            $query = "SELECT username FROM users WHERE username = :username";
            $select = $this -> conn -> prepare($query);
            $select -> bindParam(':username', $username);
            $select -> execute();
            return $select -> fetchColumn();
        } catch (PDOException $e) {
            echo $select . "<br>" . $e -> getMessage();
        }
    }

    function checkPasswordMatch (string $username) {
        try {
            $this -> useDatabase();
            $query = "SELECT password FROM users WHERE username = :username";
            $select = $this -> conn -> prepare($query);
            $select -> bindParam(':username', $username);
            $select -> execute();
            return $select -> fetchColumn();
        } catch (PDOException $e) {
            echo $select . "<br>" . $e -> getMessage();
        }
    }

    function userType (string $username) {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare('SELECT ut.name FROM users as us
            LEFT JOIN users_type as ut ON us.cod_user_type = ut.cod_user_type
            WHERE us.username = :username');
            $select -> bindParam(':username', $username);
            $select -> execute();
            return $select -> fetchColumn();
        } catch (PDOException $e) {
            echo $select . "<br>" . $e -> getMessage();
        }
    }

    function userByUsername (string $username) {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare('SELECT * FROM users WHERE username = :username');
            $select -> bindParam(':username', $username);
            $select -> execute();
            $user = $select -> fetch();
            return new User($user['name'], $user['lastnames'], $user['username'], $user['password']);
        } catch (PDOException $e) {
            echo $select . "<br>" . $e -> getMessage();
        }
    }

    function idByUsername (string $username) {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare('SELECT id_user FROM users WHERE username = :username');
            $select -> bindParam(':username', $username);
            $select -> execute();
            return $select -> fetchColumn();
        } catch (PDOException $e) {
            echo $select . "<br>" . $e -> getMessage();
        }
    }
}