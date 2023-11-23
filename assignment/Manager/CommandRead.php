<?php

declare(strict_types=1);
namespace assignment\Manager;

use assignment\CommandParameters\{AddCommandParameters,
    DeleteCommandParameters,
    GetCommandParameters,
    ListCommandParameters};
use assignment\Exceptions\{InvalidAddCommandParametersException,
    InvalidCommandNameException,
    InvalidDeleteCommandParameters,
    InvalidGetCommandParametersException,
    InvalidListCommandParametersException};
use assignment\Manager\Enums\{CommandNames};
use assignment\Manager\Operator\{CreateBook, DeleteBooks, ShowPages, ShowSelectedBook};
use assignment\Validators\{AddCommandParameterValidator,
    CommandNameValidator,
    DeleteCommandParameterValidator,
    GetCommandParameterValidator,
    ListCommandParameterValidator};

class CommandRead
{
    private CommandNames $status = CommandNames::Index;
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
            case 'Index':
                $this->status = CommandNames::Index;
                # in this case, we initialize the parameters for the Index command.
                $this->initializeListParameters(pageNumber: $commandArray["parameters"]["pageNumber"], perPage: $commandArray["parameters"]["perPage"], sort: $commandArray["parameters"]["sort"], filterByAuthor: $commandArray["parameters"]["filterByAuthor"]);
                $this->showPages();
                break;
            case 'Get':
                $this->status = CommandNames::Get;
                # in this case, we initialize the parameters for the Get command.
                $this->initializeGetParameters(ISBN: $commandArray["parameters"]["ISBN"]);
                $this->showSelectedBook();
                break;
            case 'Create':
                $this->status = CommandNames::Create;
                # in this case, we initialize the parameters for the Add command.
                $this->initializeAddParameters($commandArray);
                $this->createBook($commandArray);
                break;
            case 'Delete':
                $this->status = CommandNames::Delete;
                # in this case, we initialize the parameters for the Get command.
                $this->initializeDeleteParameters(ISBN: $commandArray["parameters"]["ISBN"]);
                $this->deleteBook();
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
    private function initializeAddParameters(array $commandArray)
    {
        try {
            $validateParameters = new AddCommandParameterValidator();

            # First we validate the file format:
            $validateParameters->validateAddToParameter($commandArray["parameters"]["addTo"]);

            # Second, We then proceed to validate the parameter's types:
            $validateParameters->validateCommandParametersTypes($commandArray);

            # Third, We validate the parameter's value:
            $validateParameters->validateParametersValue($commandArray);

        } catch (InvalidAddCommandParametersException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new AddCommandParameters
        (
            ISBN: $commandArray["parameters"]["ISBN"],
            bookTitle: $commandArray["parameters"]["bookTitle"],
            authorName: $commandArray["parameters"]["authorName"],
            pagesCount: $commandArray["parameters"]["pagesCount"],
            publishDate: $commandArray["parameters"]["publishDate"]
        );
    }
    private function initializeDeleteParameters($ISBN = "")
    {
        /*
        first, We create an array to validate the type of parameters for the Delete command and
        if its successful, we then proceed with validating the values for the Delete command parameters
        */
        $parametersArray = ["ISBN" => $ISBN];
        try {
            $validateParameters = new DeleteCommandParameterValidator();
            $validateParameters->validateCommandParametersTypes($parametersArray);
            # Validating the List command parameter's values.
            $validateParameters->validateParametersValue($parametersArray);
        } catch (InvalidDeleteCommandParameters $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new DeleteCommandParameters(ISBN: $ISBN);
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
    private function createBook(array $commandArray)
    {
        $createBook = new CreateBook
        (
            ISBN: $this->parameters->getISBN(),
            bookTitle: $this->parameters->getBookTitle(),
            authorName: $this->parameters->getAuthorName(),
            pagesCount: $this->parameters->getPagesCount(),
            publishDate: $this->parameters->getPublishDate(),
            addTo: $commandArray["parameters"]["addTo"]
        );
        $createBook->applyCreate();
    }
    private function deleteBook()
    {
        /*
        Given that now we have all the parameters we need, we begin deleting the book selected by user by
        creating a property from DeleteBook class and using it to do so.
        */
        $deleteBook = new DeleteBooks($this->parameters->getISBN());
        $deleteBook->applyDelete();
        echo "Book Deleted Successfully!";
    }
}