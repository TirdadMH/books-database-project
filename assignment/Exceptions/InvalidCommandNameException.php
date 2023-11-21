<?php

namespace assignment\Exceptions;

class InvalidCommandNameException extends \Exception
{
    public function __construct($message = "ERROR: Invalid Command Name in Command.json file.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}