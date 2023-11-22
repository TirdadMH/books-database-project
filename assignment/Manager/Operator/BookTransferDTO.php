<?php

namespace assignment\Manager\Operator;

use assignment\database\Classes\BooksDTO;

trait BookTransferDTO
{
    private function transferToBooksDTO(array $allData): array
    {
        $books = [];
        for ($i = 0; $i < sizeof($allData); $i++)
        {
            $book = new BooksDTO
            (
                ISBN: $allData[$i]["ISBN"],
                bookTitle: $allData[$i]["bookTitle"],
                authorName: $allData[$i]["authorName"],
                pagesCount: (int)$allData[$i]["pagesCount"],
                publishDate: $allData[$i]["publishDate"]
            );
            $books[] = $book;
        }
        return $books;
    }
}