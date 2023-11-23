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
        private string $publishDate = '',
    )
    {}
}