<?php

namespace assignment\database\Classes;

class WriteOntoJson implements WriteOntoDataBase
{
    public function __construct(private AddBookDTO $bookInfo)
    {
        # Converting DTO to an Array
        $bookInfoArray = $this->convertToArray();

        # Reading from books.json
        $dataBaseArray = json_decode(file_get_contents('assignment/database/books.json'), true);

        # Adding new book to the index
        $dataBaseArray["books"][] = $bookInfoArray;

        # Encoding the updated books index back to JSON and Writing the updated JSON string back to the file
        file_put_contents('assignment/database/books.json', json_encode($dataBaseArray, JSON_PRETTY_PRINT));
    }

    function convertToArray(): array
    {
        $bookInfoArray =
            [
                "ISBN" => $this->bookInfo->getISBN(),
                "bookTitle" => $this->bookInfo->getBookTitle(),
                "authorName" => $this->bookInfo->getAuthorName(),
                "pagesCount" => $this->bookInfo->getPagesCount(),
                "publishDate" => $this->bookInfo->getPublishDate()
            ];
        return $bookInfoArray;
    }
}