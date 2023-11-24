<?php

declare(strict_types=1);

namespace assignment\database\Classes;

# Open ReadFromDatabase interface for additional info.
class ReadFromCsv implements ReadFromDatabase
{
    public function __construct(){}

    public function readFromDataBase(): array
    {
        # Opening the books.csv in read-only mode.
        $csvBooks = fopen('assignment/database/books.csv', 'r');

        # calling a method that extracts books.csv content into an array.
        $dataBaseArray = $this->extractDataFromCsv($csvBooks);

        # Deleting books that are softly deleted:
        for ($i = 0; $i < sizeof($dataBaseArray); $i++)
        {
            if ($dataBaseArray[$i]["soft-deleted"] === 1)
                unset($dataBaseArray[$i]);
        }

        # Closing the books.csv.
        fclose($csvBooks);

        # Returning the books extracted from books.csv as an array.
        return $dataBaseArray;
    }

    /**
     * @param $stream
     * @return array
     */
    private function extractDataFromCsv($stream):array
    {
        # Checking if the books.csv is opened successfully:
        if ($stream !== false)
        {
            # Storing headers into an array
            $headersArray = fgetcsv($stream);

            # Storing the books into this array.
            $dataBaseArray = [];
            while (($data = fgetcsv($stream)) !== false)
            {
                $dataBaseArray[] = $data;
            }

            # Merging Headers as Keys into DataBase array.
            $combinedArray = $this->mergeHeadersIntoDataBaseArray($dataBaseArray, $headersArray);
        }
        else
        {
            die("ERROR: Can not open books.csv file.");
        }

        # Returning the Database array as combined array between headers and books info.
        return $combinedArray;
    }

    /**
     * @param array $dataBaseArray
     * @param array $headersArray
     * @return array
     */
    private function mergeHeadersIntoDataBaseArray(array $dataBaseArray, array $headersArray): array
    {
        $combinedArray = [];
        foreach ($dataBaseArray as $subArray)
        {
            $combinedArray[] = array_combine($headersArray, $subArray);
        }
        return $combinedArray;
    }
}