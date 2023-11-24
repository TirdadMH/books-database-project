<?php
declare(strict_types=1);
namespace assignment\Validators;

use assignment\Exceptions\CommandMatchException;

class CommandMatchValidator
{
    public function validateParametersKeys(array $commandArray): void
    {
        $keysArray = array_keys($commandArray["parameters"]);
        switch ($commandArray["command_name"])
        {
            case "Index":
                $this->validateIndexParametersKeys($keysArray);
                break;
            case "Get":
                $this->validateGetParametersKeys($keysArray);
                break;
            case "Create":
                $this->validateCreateParametersKeys($keysArray);
                break;
            case "Delete":
                $this->validateDeleteParametersKeys($keysArray);
                break;
            case "Update":
                $this->validateUpdateParametersKeys($keysArray);
                break;
        }
    }
    private function validateIndexParametersKeys(array $keysArray): void
    {
        if ($keysArray[0] !== "pageNumber")
            throw new CommandMatchException("ERROR: first parameter name should be \"pageNumber\".");
        if ($keysArray[1] !== "perPage")
            throw new CommandMatchException("ERROR: second parameter name should be \"perPage\".");
        if ($keysArray[2] !== "sort")
            throw new CommandMatchException("ERROR: third parameter name should be \"sort\".");
        if ($keysArray[3] !== "filterByAuthor")
            throw new CommandMatchException("ERROR: fourth parameter name should be \"filterByAuthor\".");
        if (sizeof($keysArray) !== 4)
            throw new CommandMatchException("ERROR: Number of parameters for index, should be exactly 4.");
    }
    private function validateGetParametersKeys(array $keysArray): void
    {
        if ($keysArray[0] !== "ISBN")
            throw new CommandMatchException("ERROR: ISBN parameter name should be \"ISBN\".");
        if (sizeof($keysArray) !== 1)
            throw new CommandMatchException("ERROR: Number of parameters for get, should be exactly 1.");
    }
    private function validateCreateParametersKeys(array $keysArray): void
    {
        if ($keysArray[0] !== "ISBN")
            throw new CommandMatchException("ERROR: first parameter name should be \"ISBN\".");
        if ($keysArray[1] !== "bookTitle")
            throw new CommandMatchException("ERROR: second parameter name should be \"bookTitle\".");
        if ($keysArray[2] !== "authorName")
            throw new CommandMatchException("ERROR: third parameter name should be \"authorName\".");
        if ($keysArray[3] !== "pagesCount")
            throw new CommandMatchException("ERROR: fourth parameter name should be \"pagesCount\".");
        if ($keysArray[4] !== "publishDate")
            throw new CommandMatchException("ERROR: third parameter name should be \"publishDate\".");
        if ($keysArray[5] !== "addTo")
            throw new CommandMatchException("ERROR: fourth parameter name should be \"addTo\".");
        if (sizeof($keysArray) !== 6)
            throw new CommandMatchException("ERROR: Number of parameters for create, should be exactly 6.");
    }
    private function validateDeleteParametersKeys(array $keysArray): void
    {
        if ($keysArray[0] !== "ISBN")
            throw new CommandMatchException("ERROR: ISBN parameter name should be \"ISBN\".");
        if (sizeof($keysArray) !== 1)
            throw new CommandMatchException("ERROR: Number of parameters for delete, should be exactly 1.");
    }
    private function validateUpdateParametersKeys(array $keysArray): void
    {
        if ($keysArray[0] !== "ISBN")
            throw new CommandMatchException("ERROR: first parameter name should be \"ISBN\".");
        if ($keysArray[1] !== "bookTitle")
            throw new CommandMatchException("ERROR: second parameter name should be \"bookTitle\".");
        if ($keysArray[2] !== "authorName")
            throw new CommandMatchException("ERROR: third parameter name should be \"authorName\".");
        if ($keysArray[3] !== "pagesCount")
            throw new CommandMatchException("ERROR: fourth parameter name should be \"pagesCount\".");
        if ($keysArray[4] !== "publishDate")
            throw new CommandMatchException("ERROR: third parameter name should be \"publishDate\".");
        if (sizeof($keysArray) !== 5)
            throw new CommandMatchException("ERROR: Number of parameters for update, should be exactly 5.");
    }
}