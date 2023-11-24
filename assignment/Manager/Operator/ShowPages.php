<?php

declare(strict_types=1);

namespace assignment\Manager\Operator;

use assignment\database\Classes\BookTransferDTO;
use assignment\database\Classes\ReadDataBase;

class ShowPages implements StandardOperator
{
    use BookTransferDTO;
    public function __construct(
        private int $pageNumber = 1,
        private int $perPage = 20,
        private string $sort = "Ascending",
        private string $filterByAuthor = "")
    {}
    public function applyOperator(): void
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $allData = $books->getAllData();


        # with the code written blow, we transfer the data in $allData array to an array of objects of BooksDTO:
        $books = $this->transferToBooksDTO($allData);
        unset($allData);

        # Now that we have everything we need in an array of objects from BooksDTO, we begin to show to the list:
        $viewList = new \assignment\Manager\ViewList
        (
            pageNumber: $this->pageNumber,
            perPage: $this->perPage,
            sort: $this->sort,
            filterByAuthor: $this->filterByAuthor,
            books: $books
        );
    }
}