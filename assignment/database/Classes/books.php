<?php

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

}