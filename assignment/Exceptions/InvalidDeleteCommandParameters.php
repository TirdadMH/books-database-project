<?php

namespace assignment\Exceptions;

class InvalidDeleteCommandParameters extends \Exception
{
    public function __construct($message = "ERROR: Invalid Delete Command Parameters in command.json file.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}