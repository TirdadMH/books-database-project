<?php

namespace assignment\CommandParameters;

class GetCommandParameters
{
    public function __construct
    (
        private string $ISBN = ''
    )
    {}

    public function getISBN(): string
    {
        return $this->ISBN;
    }
}