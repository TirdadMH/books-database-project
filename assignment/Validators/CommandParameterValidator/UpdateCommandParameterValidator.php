<?php

declare(strict_types=1);
namespace assignment\Validators\CommandParameterValidator;

use assignment\Exceptions\InvalidUpdateCommandParametersException;

class UpdateCommandParameterValidator implements CommandParameterValidator, ValidateISBN, ValidatePublishDate
{
    public function validateParametersValue(array $parametersArray): void
    {
        # Validating the ISBN number:
        $this->validateISBN($parametersArray["parameters"]["ISBN"]);

        # Validating the Publish Date:
        $this->validatePublishDate($parametersArray["parameters"]["publishDate"]);

        # Validating the Pages Count:
        if ($parametersArray["parameters"]["pagesCount"] < 0)
        {
            /*
             * note: If Pages Counts is equal to 0, Program simply will not update the corresponding value
               associated with the selected book.
             */
            throw new InvalidUpdateCommandParametersException("ERROR: pages count can NOT be a negative number.");
        }
    }
    public function validateCommandParametersTypes(array $parametersArray): void
    {
        if ( !(is_string($parametersArray["parameters"]["ISBN"])) ||
            !(is_string($parametersArray["parameters"]["bookTitle"])) ||
            !(is_string($parametersArray["parameters"]["authorName"])) ||
            !(is_int($parametersArray["parameters"]["pagesCount"])) ||
            !(is_string($parametersArray["parameters"]["publishDate"])))
        {
            throw new InvalidUpdateCommandParametersException();
        }
    }
    function validateISBN(string $ISBN):void
    {
        # Checking if ISBN is exactly 14 characters long.
        if (strlen($ISBN) !== 14)
            throw new InvalidUpdateCommandParametersException("ERROR: the ISBN format should be ISBN-13.");

        # Checking if 4th character of ISBN is exactly a dash: "-"
        if ($ISBN[3] !== '-')
            throw new InvalidUpdateCommandParametersException('ERROR: 4th character of ISBN must be a "-"');

        # Validating the numeric value:
        $numericPart = explode("-", $ISBN)[0];
        if (!(ctype_digit($numericPart))) // Validating if Numeric value string only contains numeric characters.
            throw new InvalidUpdateCommandParametersException("ERROR: Numeric Value is not a Number");

        # Validating the Unix timestamp:
        $unixTimeStamp = explode("-", $ISBN)[1];
        if (!(ctype_digit($unixTimeStamp))) // Validating if Unix timestamp string only contains numeric characters.
            throw new InvalidUpdateCommandParametersException("ERROR: Unix timestamp is not a Number");
    }

    function validatePublishDate(string $publishDate): void
    {
        # If it's empty, It's not a problem since program won't update anything in an empty string
        if ($publishDate !== "")
        {
            # Checking if ISBN is exactly 14 characters long.
            if (strlen($publishDate) !== 10)
                throw new InvalidUpdateCommandParametersException("ERROR: the Publish Date format should be like: 1234-01-01");

            # Checking if 5th or 8th character of publish date is exactly a dash: "-"
            if ($publishDate[4] !== '-' || $publishDate[7] !== '-')
                throw new InvalidUpdateCommandParametersException('ERROR: 5th and 8th character of Publish Date must be a "-"');

            # Validating the Year value:
            $yearPart = explode("-", $publishDate)[0];
            if (!(ctype_digit($yearPart))) // Validating if year value string only contains numeric characters.
                throw new InvalidUpdateCommandParametersException("ERROR: Year Value is not a Number");

            # Validating the Month timestamp:
            $monthPart = explode("-", $publishDate)[1];
            if (!(ctype_digit($monthPart))) // Validating if Month value string only contains numeric characters.
                throw new InvalidUpdateCommandParametersException("ERROR: Month Value is not a Number");

            # Validating the Day timestamp:
            $dayPart = explode("-", $publishDate)[2];
            if (!(ctype_digit($dayPart))) // Validating if Day value string only contains numeric characters.
                throw new InvalidUpdateCommandParametersException("ERROR: Day Value is not a Number");
        }
    }
}