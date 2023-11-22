<?php

declare(strict_types=1);
namespace assignment\database\Classes;

class ReadFromJson implements ReadFromDatabase
{
    public function __construct(){}

    public function readFromDataBase(): array
    {
        # Decoding the books.json content into an array:
        $dataBaseArray = json_decode(file_get_contents('assignment/database/books.json'), true);

        # Checking if decoding was successful:
        if ($dataBaseArray === null && json_last_error() !== JSON_ERROR_NONE)
        {
            die('Error decoding JSON: ' . json_last_error_msg());
        }
        return $dataBaseArray["books"];
    }
}