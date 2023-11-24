<?php

namespace assignment\Validators\CommandParameterValidator;

interface ValidatePublishDate
{
    function validatePublishDate(string $publishDate): void;
}