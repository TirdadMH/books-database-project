<?php

namespace assignment\Validators\CommandParameterValidator;

interface ValidateISBN
{
    function validateISBN(string $ISBN):void;
}