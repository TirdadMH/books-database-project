<?php

namespace assignment\Command_Parameters;

class ListCommandParameters
{

    public function __construct(Private int $pageNumber = 1, Private int $perPage = 10, private string $sort = 'Ascending', private string $filterByAuthor = '')
    {}
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }
    public function getPerPage(): int
    {
        return $this->perPage;
    }
    public function getSort(): string
    {
        return $this->sort;
    }
    public function getFilterByAuthor(): string
    {
        return $this->filterByAuthor;
    }
}