<?php
declare(strict_types=1);
namespace assignment\Validators;
use assignment\CommandParameters\ListCommandParameters;
use assignment\Exceptions\InvalidListCommandParametersException;

class ListCommandParameterValidator implements CommandParameterValidator
{
    public function validateParametersValue(array $parametersArray): void
    {
        if (($parametersArray["pageNumber"] < 1) || ($parametersArray["perPage"] < 1))
        {
            throw new InvalidListCommandParametersException();
        }
        switch ($parametersArray["sort"])
        {
            case "Ascending":
            case "Descending":
                break;
            default:
                throw new InvalidListCommandParametersException();
        }
    }

    public function validateCommandParametersTypes(array $parametersArray): void
    {
        if ( !(is_int($parametersArray["pageNumber"])) || !(is_int($parametersArray["perPage"])) || !(is_string($parametersArray["sort"])) || !(is_string($parametersArray["filterByAuthor"])))
        {
            throw new InvalidListCommandParametersException();
        }
    }
}