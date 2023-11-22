<?php

namespace assignment\Exceptions;

class InvalidGetCommandParametersException extends \Exception
{
    public function __construct($message = "ERROR: Invalid Get Command Parameters in command.json file.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}