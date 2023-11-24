<?php

namespace assignment\CommandParameters;

class GetCommandParameters implements CommandParameters
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