<?php

declare(strict_types=1);
namespace assignment\Manager;

use assignment\Manager\Operator\ShowSelectedBook;
use assignment\CommandParameters\{GetCommandParameters, ListCommandParameters};
use assignment\Exceptions\{InvalidCommandNameException,
    InvalidGetCommandParametersException,
    InvalidListCommandParametersException};
use assignment\Manager\Enums\CommandNames;
use assignment\Manager\Operator\ShowPages;
use assignment\Validators\{CommandNameValidator, GetCommandParameterValidator, ListCommandParameterValidator};

class CommandRead
{
    private CommandNames $status = CommandNames::List;
    private $parameters;

    public function __construct()
    {
        # Validating command name.
        $commandArray = $this->validateCommandName();

        # Initializing the $status property.
        $this->initializeStatusValue($commandArray);
    }

    private function validateCommandName(): array
    {
        # Extracting command.json file's content to an array using another function.
        $commandArray = $this->extractFromJson();

        /*
            Validating the Name of the Command written in commands.json file
            and if it fails, we throw an error regarding the Invalid command name.
        */
        try {
            $nameValidation = new CommandNameValidator();
            $nameValidation->validateName($commandArray["command_name"]);
        } catch (InvalidCommandNameException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # If everything was successful, then we proceed with the correct command name extracted from the file.
        return $commandArray;
    }
    private function extractFromJson(): array
    {
        return json_decode(file_get_contents('assignment/commands.json'), true);
    }
    private function initializeStatusValue(array $commandArray): void
    {
        # First, we detect which type of command we will do, then we proceed with its parameters.
        switch ($commandArray["command_name"])
        {
            case 'List':
                $this->status = CommandNames::List;
                # in this case, we initialize the parameters for the List command.
                $this->initializeListParameters(pageNumber: $commandArray["parameters"]["pageNumber"], perPage: $commandArray["parameters"]["perPage"], sort: $commandArray["parameters"]["sort"], filterByAuthor: $commandArray["parameters"]["filterByAuthor"]);
                $this->showPages();
                break;
            case 'Get':
                $this->status = CommandNames::Get;
                # in this case, we initialize the parameters for the List command.
                $this->initializeGetParameters(ISBN: $commandArray["parameters"]["ISBN"]);
                $this->showSelectedBook();
                break;
            case 'Add':
                $this->status = CommandNames::Add;
                break;
            case 'Delete':
                $this->status = CommandNames::Delete;
                break;
            case 'Update':
                $this->status = CommandNames::Update;
                break;
        }
    }
    private function initializeListParameters($pageNumber = 1, $perPage = 10, $sort = "Ascending", $filterByAuthor = ""): void
    {
        
    /*
        first, We create an array to validate the type of parameters for the List command and
        if its successful, we then proceed with validating the values for the List command parameters
    */
        $parametersArray = ["pageNumber" => $pageNumber, "perPage" => $perPage, "sort" => $sort, "filterByAuthor" => $filterByAuthor];
        try {
            $validateParameters = new ListCommandParameterValidator();
            $validateParameters->validateCommandParametersTypes($parametersArray);
            # Validating the List command parameter's values.
            $validateParameters->validateParametersValue($parametersArray);
        } catch (InvalidListCommandParametersException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new ListCommandParameters(pageNumber: $pageNumber, perPage: $perPage, sort: $sort, filterByAuthor: $filterByAuthor);
    }
    private function initializeGetParameters($ISBN = "")
    {

    /*
        first, We create an array to validate the type of parameters for the Get command and
        if its successful, we then proceed with validating the values for the Get command parameters
    */
        $parametersArray = ["ISBN" => $ISBN];
        try {
            $validateParameters = new GetCommandParameterValidator();
            $validateParameters->validateCommandParametersTypes($parametersArray);
            # Validating the List command parameter's values.
            $validateParameters->validateParametersValue($parametersArray);
        } catch (InvalidGetCommandParametersException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new GetCommandParameters(ISBN: $ISBN);
    }
    private function showPages()
    {

        $showPages = new ShowPages($this->parameters->getPageNumber(), $this->parameters->getPerPage(), $this->parameters->getSort(), $this->parameters->getFilterByAuthor());
        $showPages->applyView();
    }
    private function showSelectedBook()
    {
        /*
        Given that now we have all the parameters we need, we begin showing the book selected by user by
        creating a property from ShowSelectedPage class and using it to do so.
        */
        $showSelectedBook = new ShowSelectedBook($this->parameters->getISBN());
        $showSelectedBook->applyView();
    }
}