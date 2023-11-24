<?php

namespace assignment\Manager\Operator;

trait UpdateDataBaseFiles
{
    private function updateCsvFile(array $csvData): void
    {
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

    private function updateJsonFile(array $jsonData): void
    {
        $readyToJson = ["books" => $jsonData];
        file_put_contents('assignment/database/books.json', json_encode($readyToJson, JSON_PRETTY_PRINT));
    }
}