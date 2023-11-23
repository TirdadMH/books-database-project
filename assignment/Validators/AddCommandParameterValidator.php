<?php

namespace assignment\Validators;

use assignment\Exceptions\InvalidAddCommandParametersException;

class AddCommandParameterValidator implements CommandParameterValidator
{
    public function validateParametersValue(array $parametersArray): void
    {

    }
    public function validateCommandParametersTypes(array $parametersArray): void
    {
        if ( !(is_string($parametersArray[""])) || !(is_int($parametersArray["perPage"])) || !(is_string($parametersArray["sort"])) || !(is_string($parametersArray["filterByAuthor"])))
        {
            throw new InvalidAddCommandParametersException();
        }
    }
    public function validateAddToParameter(string $addTo)
    {
        switch ($addTo)
        {
            case 'json':
            case 'csv':
                break;
            default:
                throw new InvalidAddCommandParametersException("ERROR: AddTo parameter must be either csv or json.");
        }
    }

}