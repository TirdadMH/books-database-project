<?php

namespace assignment\Exceptions;

class CommandMatchException extends \Exception
{
    public function __construct($message = "ERROR: Command Name and Command Parameters don't match.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}