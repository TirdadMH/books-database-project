<?php

namespace assignment\Manager;

class ShowPages
{
    private int $pageNumber = 1;
    private int $perPage = 10;
    private string $sort = "Ascending";
    private string $filterBy = "Author";

    public function __construct(int $pageNumber, int $perPage, string $sort, string $filterBy)
    {
        $this->pageNumber = $pageNumber;
        $this->perPage = $perPage;
        $this->sort = $sort;
        $this->filterBy = $filterBy;
    }

    public function applyViewPages()
    {
        echo 'Showing Pages.';
    }
}