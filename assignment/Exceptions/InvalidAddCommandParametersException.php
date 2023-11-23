<?php

namespace assignment\Exceptions;

class InvalidAddCommandParametersException extends \Exception
{
    public function __construct($message = "ERROR: Add Command Parameters in command.json file.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}