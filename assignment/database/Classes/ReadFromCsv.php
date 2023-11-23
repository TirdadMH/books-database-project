<?php

declare(strict_types=1);

namespace assignment\database\Classes;

class ReadFromCsv
{
    public function __construct(){}

    public function readFromDataBase(): array
    {
        $csvBooks = fopen('assignment/database/books.csv', 'r');
        $dataBaseArray = $this->extractDataFromCsv($csvBooks);

        # Deleting books that are softly deleted:
        for ($i = 0; $i < sizeof($dataBaseArray); $i++)
        {
            if ($dataBaseArray[$i]["soft-deleted"] === 1)
                unset($dataBaseArray[$i]);
        }
        fclose($csvBooks);
        return $dataBaseArray;
    }

    private function extractDataFromCsv($stream):array
    {
        # Checking if the books.csv is opened successfully:
        if ($stream !== false)
        {
            $headersArray = fgetcsv($stream);

            $dataBaseArray = [];
            while (($data = fgetcsv($stream)) !== false)
            {
                $dataBaseArray[] = $data;
            }

            $combinedArray = $this->mergeHeadersIntoDataBaseArray($dataBaseArray, $headersArray);
        }
        else
        {
            die("ERROR: Can not open .csv file.");
        }
        return $combinedArray;
    }
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