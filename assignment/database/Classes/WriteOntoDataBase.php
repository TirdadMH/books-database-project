<?php

namespace assignment\database\Classes;

interface WriteOntoDataBase
{
    public function __construct(AddBookDTO $bookInfo);
    function convertToArray(): array;
}