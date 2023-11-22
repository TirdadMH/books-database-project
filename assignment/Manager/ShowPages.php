<?php

declare(strict_types=1);

namespace assignment\Manager;

use assignment\database\Classes\ReadDataBase;

class ShowPages
{

    public function __construct(
        private int $pageNumber = 1,
        private int $perPage = 10,
        private string $sort = "Ascending",
        private string $filterByAuthor = "")
    {}

    public function applyViewPages()
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $allData = $books->getAllData();
    }
}