<?php

declare(strict_types=1);
namespace assignment\database\Classes;

class books
{
    public function __construct(
        private string $ISBN = "",
        private string $bookTitle = "",
        private string $authorName = "",
        private int $pagesCount = 0,
        private string $publishDate = ""
    )
    {}

    public function readDataBase()
    {
        $readFromJson = new ReadFromJson();
        $readFromCsv = new ReadFromCsv();
        $dataFromJson = $readFromJson->readFromDataBase();
        $dataFromCsv = $readFromCsv->readFromDataBase();
    }
}

//echo '<pre>';
//print_r($dataFromJson);
//echo '</pre>';
//echo '</br>';

