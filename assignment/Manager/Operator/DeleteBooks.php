<?php
declare(strict_types=1);
namespace assignment\Manager\Operator;

use assignment\database\Classes\ReadDataBase;

class DeleteBooks
{
    public function __construct(private string $ISBN = "")
    {}
    public function applyDelete(): void
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $csvData = $books->getCsvData();
        $jsonData = $books->getJsonData();

        # Getting index of the book we need to soft-delete:
        $index0fJson = $this->getISBNIndex($jsonData);
        $index0fCsv = $this->getISBNIndex($csvData);

        if ($index0fCsv === -1 && $index0fJson !== -1)
        {
            # Now we Delete:
            $jsonData = $this->deleteBook($index0fJson, $jsonData);
            $readyToJson = ["books" => $jsonData];
            file_put_contents('assignment/database/books.json', json_encode($readyToJson, JSON_PRETTY_PRINT));
        }
        else if ($index0fCsv !== -1 && $index0fJson === -1)
        {
            # Now we Delete:
            $csvData = $this->deleteBook($index0fCsv, $csvData);

            # Getting header from books.csv file:
            $csvBooks = fopen('assignment/database/books.csv', 'r');
            $headersArray = fgetcsv($csvBooks);
            fclose($csvBooks);

            # Clearing the content of books.csv file
            $csvBooks = fopen('assignment/database/books.csv', 'w');
            fclose($csvBooks);

            # Opening a file handle for adding new book
            $csvBooks = fopen('assignment/database/books.csv', 'a');

            # Putting Header back in the cleared file:
            fputcsv($csvBooks, $headersArray);

            # Putting everything back together
            foreach ($csvData as $data)
                {
                    # rewriting the Array as a CSV row:
                    fputcsv($csvBooks, $data);
                }

            # Closing the file handle
            fclose($csvBooks);
        }
        else if ($index0fCsv === -1 && $index0fJson === -1)
        {
            echo "Book Not Found!";
            exit();
        }
    }

    private function getISBNIndex(array $data): int|string
    {
        for ($i = 0; $i < sizeof($data); $i++)
        {
            if ($this->ISBN === $data[$i]["ISBN"])
            {
                if ($data[$i]["soft-deleted"] === "1")
                {
                    echo "Book Not Found!";
                    exit();
                }
                else
                    return $i;
            }
        }
        return -1;
    }
    private function deleteBook(int $index, array $data): array
    {
        $data[$index]["soft-deleted"] = 1;
        return $data;
    }
}