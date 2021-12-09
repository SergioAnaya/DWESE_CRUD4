<?php

class Book {

    private string $bookId;
    private string $title;
    private string $author;
    private string $editorial;

    function __construct (string $title, string $author, string $editorial) {
        $this -> title = $title;
        $this -> author = $author;
        $this -> editorial = $editorial;
    }

    public function setBookId ($id) {
        $this -> bookId = $id;
    }

    public function getBookId (): string {
        return $this -> bookId;
    }

    public function getTitle (): string {
        return $this -> title;
    }

    public function getAuthor (): string {
        return $this -> author;
    }

    public function getEditorial (): string {
        return $this -> editorial;
    }
}