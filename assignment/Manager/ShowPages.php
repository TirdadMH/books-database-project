<?php

declare(strict_types=1);

namespace assignment\Manager;

use assignment\database\Classes\BooksDTO;
use assignment\Manager\ViewList;
use assignment\database\Classes\ReadDataBase;

class ShowPages
{

    public function __construct(
        private int $pageNumber = 1,
        private int $perPage = 10,
        private string $sort = "Ascending",
        private string $filterByAuthor = "")
    {}

    public function applyViewPages(): void
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $allData = $books->getAllData();


        # with the code written blow, we transfer the data in $allData array to an array of objects of BooksDTO:
        $books = $this->transferToBooksDTO($allData);
        unset($allData);

        # Now that we have everything we need in an array of objects from BooksDTO, we begin to show to the list:
        

    }

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