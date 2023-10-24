<?php
class Book {
    private $title;
    private $author;
    private $isbn;
    private $available;

    public function __construct($title, $author, $isbn) {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->available = true;
    }

    public function borrow() {
        if ($this->available) {
            $this->available = false;
            return true; // Book is successfully borrowed
        } else {
            return false; // Book is already borrowed
        }
    }

    public function returnBook() {
        $this->available = true;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }
}

class Library {
    private $books = [];

    public function addBook($book) {
        $this->books[] = $book;
    }

    public function findBookByISBN($isbn) {
        foreach ($this->books as $book) {
            if ($book->isbn === $isbn) {
                return $book;
            }
        }
        return null; // Book not found
    }
}

// Usage
$book1 = new Book("The Catcher in the Rye", "J.D. Salinger", "9780316769488");
$book2 = new Book("To Kill a Mockingbird", "Harper Lee", "9780061120084");

$library = new Library();
$library->addBook($book1);
$library->addBook($book2);

$bookToBorrow = $library->findBookByISBN("9780316769488");

if ($bookToBorrow) {
    if ($bookToBorrow->borrow()) {
        echo "You have borrowed '{$bookToBorrow->getTitle()}' by {$bookToBorrow->getAuthor()}.";
    } else {
        echo "Sorry, '{$bookToBorrow->getTitle()}' is already borrowed.";
    }
} else {
    echo "Book not found in the library.";
}

?>