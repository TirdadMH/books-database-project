<?php

namespace assignment\CommandParameters;

class DeleteCommandParameters
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