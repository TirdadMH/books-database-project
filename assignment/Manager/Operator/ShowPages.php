<?php

declare(strict_types=1);

namespace assignment\Manager\Operator;

use assignment\database\Classes\{BookTransferDTO, ReadDataBase};

# every single class that applies the commands, is implemented from StandardOperator interface.
class ShowPages implements StandardOperator
{
    # Open the trait file to read the description.
    use BookTransferDTO;
    public function __construct(
        private int $pageNumber = 1,
        private int $perPage = 20,
        private string $sort = "Ascending",
        private string $filterByAuthor = "")
    {}
    public function applyOperator(): void
    {
        # First thing first: code reads from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $allData = $books->getAllData();


        # with the code written blow, we transfer the data in $allData array to an array of objects of BooksDTO:
        $books = $this->transferToBooksDTO($allData);

        # code doesn't need the $allData array as it's got everything in a DTO.
        unset($allData);

        /*
            Now that code has everything it needs in an array of objects from BooksDTO,
            it begins to show the list by creating an object from another class that its job is
            to show the indexes.
        */
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