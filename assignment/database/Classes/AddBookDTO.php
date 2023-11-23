<?php

namespace assignment\database\Classes;

class AddBookDTO extends BooksDTO
{
    public function __construct(
        string $ISBN = "",
        string $bookTitle = "",
        string $authorName = "",
        int $pagesCount = 0,
        string $publishDate = "",
        private string $addTo = ""
    ) {
        parent::__construct($ISBN, $bookTitle, $authorName, $pagesCount, $publishDate);
    }
}