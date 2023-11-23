<?php

namespace assignment\CommandParameters;

use assignment\Manager\Enums\DataBaseFileFormat;

class AddCommandParameters
{
    public function __construct
    (
        private string $ISBN = '',
        private string $bookTitle = '',
        private string $authorName = '',
        private int $pagesCount = 0,
        private string $publishDate = ''
    )
    {}

    public function getISBN(): string
    {
        return $this->ISBN;
    }

    public function getBookTitle(): string
    {
        return $this->bookTitle;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getPagesCount(): int
    {
        return $this->pagesCount;
    }

    public function getPublishDate(): string
    {
        return $this->publishDate;
    }
}