<?php

namespace assignment\Manager\Operator;

use assignment\database\Classes\BookTransferDTO;
use assignment\database\Classes\ReadDataBase;
use assignment\Manager\ViewSelected;

class ShowSelectedBook implements StandardOperator
{
    use BookTransferDTO;
    public function __construct(private string $ISBN = "")
    {}
    public function applyView(): void
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $allData = $books->getAllData();

        # with the code written blow, we transfer the data in $allData array to an array of objects of BooksDTO:
        $books = $this->transferToBooksDTO($allData);
        unset($allData);

        # Now that we have everything we need in an array of objects from BooksDTO, we begin to show the selected book:
        $viewSelected = new ViewSelected(ISBN: $this->ISBN, books: $books);
    }
}

//        echo '<pre>';
//        var_dump($books);
//        echo '</pre>';
