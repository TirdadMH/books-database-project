<?php

namespace assignment\database\Classes;

class WriteOntoCsv implements WriteOntoDataBase
{
    public function __construct(private AddBookDTO $bookInfo)
    {
        # Converting DTO to an Array
        $bookInfoArray = $this->convertToArray();

        # Now we write the info to the .csv file:
        $this->writeToCsv($bookInfoArray);
    }

    function convertToArray(): array
    {
        $bookInfoArray =
            [
                $this->bookInfo->getISBN(),
                $this->bookInfo->getBookTitle(),
                $this->bookInfo->getAuthorName(),
                $this->bookInfo->getPagesCount(),
                $this->bookInfo->getPublishDate()
            ];
        return $bookInfoArray;
    }
    private function writeToCsv(array $bookInfoArray)
    {
        # Opening a file handle for adding new book
        $csvBooks = fopen('assignment/database/books.csv', 'a');

        # Writing the Array as a CSV row:
        fputcsv($csvBooks, $bookInfoArray);

        # Closing the file handle
        fclose($csvBooks);
    }
}
