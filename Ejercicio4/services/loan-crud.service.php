<?php

require_once(realpath(dirname(__FILE__) . '/../../DBConn.php'));

class loanCrud {

    private PDO $conn;

    function __construct() {
        $conn = new DBConn();
        $this -> conn = $conn -> getConn();
    }

    private function useDatabase(string $database = 'db_library') {
        $sql = "USE " . $database;
        $this -> conn -> exec($sql);
    }

    function addLoan (string $userId, string $bookId, string $date) {
        try {
            $this -> useDatabase();
            $insert = $this -> conn -> prepare('INSERT INTO loans (id_user, id_book, loan_date) VALUES (:userId, :bookId, :loanDate)');
            $insert -> bindParam(':userId', $userId);
            $insert -> bindParam(':bookId', $bookId);
            $insert -> bindParam(':loanDate', $date);
            $insert -> execute();
        } catch(PDOException $e) {
            echo $e -> getMessage();
        }
    }

    function deleteLoan (string $userId, string $bookId) {
        try {
            $this -> useDatabase();
            $delete = $this -> conn -> prepare('DELETE FROM loans WHERE id_user = :userId AND id_book = :bookId');
            $delete -> bindParam(':userId', $userId);
            $delete -> bindParam(':bookId', $bookId);
            $delete -> execute();
        } catch (PDOException $e) {
            echo $delete . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to count loans. (Pagination)
     */

    private function countLoans () {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare("SELECT count(*) FROM loans");
            $select -> execute();
            $loans = $select -> fetchAll();
            return $loans[0][0];
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to return the array of loans per page. (Pagination)
     */

    private function loansByPage (int $page, int $per_page) {
        try {
            $this -> useDatabase();
            $select = "SELECT us.username as users_username, us.id_user as user_id, bo.title as books_title, bo.id_book as book_id, lo.loan_date as loans_date FROM loans as lo
            left JOIN users us on us.id_user = lo.id_user
            left JOIN books bo on bo.id_book = lo.id_book
            LIMIT " . (($page - 1) * $per_page) . "," . $per_page;
            $select = $this -> conn -> prepare($select);
            $select -> execute();
            return $select -> fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    public function printLoansList () {
        $this -> useDatabase();
        if (array_key_exists('pg', $_GET)) {
            $page = $_GET['pg'];
        } else $page = 1;

        $limit = 2;
        $countOfLoans = $this -> countLoans();
        $max_num_pages = ceil($countOfLoans / $limit);

        foreach($this -> loansByPage($page, $limit) as $loan) {
            echo '
                    <tr>
                    <td>' . $loan -> users_username .'</td>
                    <td>' . $loan -> books_title .'</td>
                    <td>' . $loan -> loans_date .'</td>
                    <td><a href="loans.php?bookId=' . $loan -> book_id . '&userId=' . $loan -> user_id . '&action=delete"><i class="material-icons">delete</i></a></td>
                    </tr>';
        }
        for ($i = 0; $i < $max_num_pages; $i++) {
            echo '<span><a href="loans.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a> - </span>';
        }
    }

    /**
     * Method to count loans. (Pagination)
     */

    private function countUsersLoans (string $userId) {
        try {
            $this -> useDatabase();
            $select = $this -> conn -> prepare("SELECT count(*) FROM loans WHERE id_user = :userId");
            $select -> bindParam(':userId', $userId);
            $select -> execute();
            $loans = $select -> fetchAll();
            return $loans[0][0];
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    /**
     * Method to return the array of loans per page. (Pagination)
     */

    private function usersLoansByPage (int $page, int $per_page, string $userId) {
        try {
            $this -> useDatabase();
            $select = "SELECT us.username as users_username, us.id_user as user_id, bo.title as books_title, bo.id_book as book_id, lo.loan_date as loans_date FROM loans as lo
            left JOIN users us on us.id_user = lo.id_user
            left JOIN books bo on bo.id_book = lo.id_book WHERE lo.id_user = :userId
            LIMIT " . (($page - 1) * $per_page) . "," . $per_page;
            $select = $this -> conn -> prepare($select);
            $select -> bindParam(':userId', $userId);
            $select -> execute();
            return $select -> fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo 'Error'  . "<br>" . $e -> getMessage();
        }
    }

    public function printUsersLoansList (string $userId) {
        $this -> useDatabase();
        if (array_key_exists('pg', $_GET)) {
            $page = $_GET['pg'];
        } else $page = 1;

        $limit = 2;
        $countOfLoans = $this -> countUsersLoans($userId);
        $max_num_pages = ceil($countOfLoans / $limit);

        foreach($this -> usersLoansByPage($page, $limit, $userId) as $loan) {
            echo '
                    <tr>
                    <td>' . $loan -> books_title .'</td>
                    <td>' . $loan -> loans_date .'</td>
                    </tr>';
        }
        for ($i = 0; $i < $max_num_pages; $i++) {
            echo '<span><a href="loans.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a> - </span>';
        }
    }

    function bookAvailability (string $bookId) {
        try {
            $this -> useDatabase();
            $query = "SELECT id_book FROM loans WHERE id_book = :bookId";
            $select = $this -> conn -> prepare($query);
            $select -> bindParam(':bookId', $bookId);
            $select -> execute();
            $books = $select -> fetch();
            return (bool) $books;
        } catch (PDOException $e) {
            echo $select . "<br>" . $e -> getMessage();
        }
    }

}