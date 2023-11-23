<?php
declare(strict_types=1);
namespace assignment\Validators;

use assignment\Exceptions\InvalidAddCommandParametersException;

class AddCommandParameterValidator implements CommandParameterValidator, ValidateISBN
{
    public function validateParametersValue(array $parametersArray): void
    {
        $this->validateISBN($parametersArray["parameters"]["ISBN"]);
        $this->validatePublishDate($parametersArray["parameters"]["publishDate"]);
        if ($parametersArray["parameters"]["pagesCount"] < 0)
            throw new InvalidAddCommandParametersException('ERROR: pageCount parameter can NOT be a negative number.');
    }
    public function validateCommandParametersTypes(array $parametersArray): void
    {
        if ( !(is_string($parametersArray["parameters"]["ISBN"])) ||
             !(is_string($parametersArray["parameters"]["bookTitle"])) ||
             !(is_string($parametersArray["parameters"]["authorName"])) ||
             !(is_int($parametersArray["parameters"]["pagesCount"])) ||
             !(is_string($parametersArray["parameters"]["publishDate"])))
        {
            throw new InvalidAddCommandParametersException();
        }
    }
    public function validateAddToParameter(string $addTo): void
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
    public function validateISBN(string $ISBN):void
    {
        # Checking if ISBN is exactly 14 characters long.
        if (strlen($ISBN) !== 14)
            throw new InvalidAddCommandParametersException("ERROR: the ISBN format should be ISBN-13.");

        # Checking if 4th character of ISBN is exactly a dash: "-"
        if ($ISBN[3] !== '-')
            throw new InvalidAddCommandParametersException('ERROR: 4th character of ISBN must be a "-"');

        # Validating the numeric value:
        $numericPart = explode("-", $ISBN)[0];
        if (!(ctype_digit($numericPart))) // Validating if Numeric value string only contains numeric characters.
            throw new InvalidAddCommandParametersException("ERROR: Numeric Value is not a Number");

        # Validating the Unix timestamp:
        $unixTimeStamp = explode("-", $ISBN)[1];
        if (!(ctype_digit($unixTimeStamp))) // Validating if Unix timestamp string only contains numeric characters.
            throw new InvalidAddCommandParametersException("ERROR: Unix timestamp is not a Number");
    }
    private function validatePublishDate(string $publishDate): void
    {
        # Checking if ISBN is exactly 14 characters long.
        if (strlen($publishDate) !== 10)
            throw new InvalidAddCommandParametersException("ERROR: the Publish Date format should be like: 1234-01-01");

        # Checking if 5th or 8th character of publish date is exactly a dash: "-"
        if ($publishDate[4] !== '-' || $publishDate[7] !== '-')
            throw new InvalidAddCommandParametersException('ERROR: 5th and 8th character of Publish Date must be a "-"');

        # Validating the Year value:
        $yearPart = explode("-", $publishDate)[0];
        if (!(ctype_digit($yearPart))) // Validating if year value string only contains numeric characters.
            throw new InvalidAddCommandParametersException("ERROR: Year Value is not a Number");

        # Validating the Month timestamp:
        $monthPart = explode("-", $publishDate)[1];
        if (!(ctype_digit($monthPart))) // Validating if Month value string only contains numeric characters.
            throw new InvalidAddCommandParametersException("ERROR: Month Value is not a Number");

        # Validating the Day timestamp:
        $dayPart = explode("-", $publishDate)[2];
        if (!(ctype_digit($dayPart))) // Validating if Day value string only contains numeric characters.
            throw new InvalidAddCommandParametersException("ERROR: Day Value is not a Number");
    }
}