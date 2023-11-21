<?php

namespace assignment\Exceptions;

class InvalidListCommandParametersException extends \Exception
{
    public function __construct($message = "ERROR: Invalid List Command Parameters in command.json file.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}