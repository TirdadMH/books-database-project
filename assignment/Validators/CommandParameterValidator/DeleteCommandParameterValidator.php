<?php

namespace assignment\Validators\CommandParameterValidator;

use assignment\Exceptions\InvalidDeleteCommandParametersException;

class DeleteCommandParameterValidator implements CommandParameterValidator, ValidateISBN
{
    public function validateParametersValue(array $parametersArray): void
    {
        $this->validateISBN($parametersArray["ISBN"]);
    }
    public function validateCommandParametersTypes(array $parametersArray): void
    {
        if (!(is_string($parametersArray["ISBN"])))
        {
            throw new InvalidDeleteCommandParametersException("ERROR: ISBN must be String");
        }
    }
    function validateISBN(string $ISBN):void
    {
        # Checking if ISBN is exactly 14 characters long.
        if (strlen($ISBN) !== 14)
            throw new InvalidDeleteCommandParametersException("ERROR: the ISBN format should be ISBN-13.");

        # Checking if 4th character of ISBN is exactly a dash: "-"
        if ($ISBN[3] !== '-')
            throw new InvalidDeleteCommandParametersException('ERROR: 4th character of ISBN must be a "-"');

        # Validating the numeric value:
        $numericPart = explode("-", $ISBN)[0];
        if (!(ctype_digit($numericPart))) // Validating if Numeric value string only contains numeric characters.
            throw new InvalidDeleteCommandParametersException("ERROR: Numeric Value is not a Number");

        # Validating the Unix timestamp:
        $unixTimeStamp = explode("-", $ISBN)[1];
        if (!(ctype_digit($unixTimeStamp))) // Validating if Unix timestamp string only contains numeric characters.
            throw new InvalidDeleteCommandParametersException("ERROR: Unix timestamp is not a Number");
    }
}