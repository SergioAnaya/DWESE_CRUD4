<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class//DesWebEnEntSer/1Trim/EjerciciosCRUD/Ejercicio4/Private/Config/config.php';
global $config;
require_once $config['paths']['db_connection'];
require_once $config['paths']['models']['book'];

class bookCrud {

    private PDO $conn;

    function __construct () {
        $conn = new DBConn();
        $this -> conn = $conn -> getConn();
    }

    private function useDatabase (string $database = 'db_library') {
        $sql = "USE " . $database;
        $this -> conn -> exec($sql);
    }

    /**
     * Method to count all books. (Pagination)
     */

    private function countBooks () {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare("SELECT count(*) FROM books");
            $select -> execute();
            $books = $select -> fetchAll();
            return $books[0][0];
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to return the array of books per page. (Pagination)
     */

    private function booksByPage (int $page, int $per_page) {
        try {
            $this -> useDatabase();
            $select = "SELECT * FROM books LIMIT " . (($page - 1) * $per_page) . "," . $per_page;
            $select = $this -> conn -> prepare($select);
            $select -> execute();
            return $select -> fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to print all books.
     */

    public function printBooksList () {
        $this -> useDatabase();
        if (array_key_exists('pg', $_GET)) {
            $page = $_GET['pg'];
        } else $page = 1;

        $limit = 2;
        $countOfBooks = $this -> countBooks();
        $max_num_pages = ceil($countOfBooks / $limit);

        foreach($this -> booksByPage($page, $limit) as $book) {
            echo '
                    <tr>
                    <td>' . $book -> title .'</td>
                    <td>' . $book -> author .'</td>
                    <td>' . $book -> editorial .'</td>
                    <td><a href="loan.php?bookId=' . $book -> id_book . '&bookTitle=' . $book -> title . '"><i class="material-icons">add</i></a></td>
                    </tr>';
        }
        for ($i = 0; $i < $max_num_pages; $i++) {
            echo '<span><a href="books.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a> - </span>';
        }
    }
}