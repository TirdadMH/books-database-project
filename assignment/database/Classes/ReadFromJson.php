<?php

declare(strict_types=1);
namespace assignment\database\Classes;

# Open ReadFromDatabase interface for additional info.
class ReadFromJson implements ReadFromDatabase
{
    public function __construct(){}

    /**
     * @return array
     */
    public function readFromDataBase(): array
    {
        # Decoding the books.json content into an array:
        $dataBaseArray = json_decode(file_get_contents('assignment/database/books.json'), true);

        # Deleting books that are softly deleted:
        for ($i = 0; $i < sizeof($dataBaseArray["books"]); $i++)
        {
            if ($dataBaseArray["books"][$i]["soft-deleted"])
                unset($dataBaseArray["books"][$i]);
        }

        # Checking if decoding was successful:
        if ($dataBaseArray === null && json_last_error() !== JSON_ERROR_NONE)
        {
            die('ERROR decoding JSON: ' . json_last_error_msg());
        }

        # Returning books read from books.json in an array.
        return $dataBaseArray["books"];
    }
}