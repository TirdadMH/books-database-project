<?php

namespace assignment\Manager\Operator;

interface GetIndex
{
    function getISBNIndex(array $data): int;
}