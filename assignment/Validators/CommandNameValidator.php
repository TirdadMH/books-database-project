<?php
declare(strict_types=1);
namespace assignment\Validators;

use assignment\Exceptions\InvalidCommandNameException;

class CommandNameValidator
{
    public function validateName(string $CommandName)
    {
        switch ($CommandName)
        {
            case 'Index':
            case 'Create':
            case 'Get':
            case 'Delete':
            case 'Update':
                break;
            default:
                throw new InvalidCommandNameException();
        }
    }
}