<?php

declare(strict_types=1);
namespace assignment\Manager;

# All the Namespaces used in this project.
use assignment\CommandParameters\{
    AddCommandParameters,
    DeleteCommandParameters,
    GetCommandParameters,
    ListCommandParameters,
    UpdateCommandParameters,
    CommandParameters};

use assignment\Exceptions\{
    CommandMatchException,
    InvalidAddCommandParametersException,
    InvalidCommandNameException,
    InvalidDeleteCommandParametersException,
    InvalidGetCommandParametersException,
    InvalidListCommandParametersException,
    InvalidUpdateCommandParametersException};

use assignment\Manager\Enums\{CommandNames};
use assignment\Manager\Operator\{CreateBook, DeleteBooks, ShowPages, ShowSelectedBook, UpdateBook};

use assignment\Validators\CommandParameterValidator\{
    AddCommandParameterValidator,
    DeleteCommandParameterValidator,
    GetCommandParameterValidator,
    ListCommandParameterValidator,
    UpdateCommandParameterValidator};

use assignment\Validators\{CommandMatchValidator, CommandNameValidator,};

class CommandRead
{
    # Status property will determine behaving of the code.
    private CommandNames $status = CommandNames::Index;

    # Parameters property stores the parameters read from commands.json file.
    private CommandParameters $parameters; // Use of polymorphism here.

    # Basically, all the work is done under these 3 line of code in the constructor of CommandRead class.
    public function __construct()
    {
        # Validating command name.
        $commandArray = $this->validateCommandName();

        # Validating a match between command name and command parameters.
        $this->validateMatch($commandArray);

        # Initializing the $status property.
        $this->initializeStatusValue($commandArray);
    }

    private function validateCommandName(): array
    {
        /*
            Extracting command.json file's content to an array using another function.
            If it's not successful, code throws an exception in extractFromJson() method.
        */
        try
        {
            $commandArray = $this->extractFromJson();
        }
        catch (CommandMatchException $e)
        {
            echo $e->getMessage();
            exit();
        }

        /*
            Validating the Name of the Command written in commands.json file
            and if it fails, code throws an error regarding the Invalid command name.
        */
        try
        {
            $nameValidation = new CommandNameValidator();
            $nameValidation->validateName($commandArray["command_name"]);
        }
        catch (InvalidCommandNameException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # If everything was successful, code then proceeds with the correct command name extracted from the commands.json file.
        return $commandArray;
    }

    /**
     * @return array
     * @throws CommandMatchException
     */
    private function extractFromJson(): array
    {
        # Extracting info from commands.json
        $commandArray = json_decode(file_get_contents('assignment/commands.json'), true);

        # Checking if extraction was a success.
        if ($commandArray === null)
            throw new CommandMatchException("wtf I suppose to do with this? :\\");

        # Returning an array of commands and parameters extracted from commands.json
        return $commandArray;
    }
    private function validateMatch(array $commandArray): void
    {
        try
        {
            $commandMatchValidator = new CommandMatchValidator();
            $commandMatchValidator->validateParametersKeys($commandArray);
        } catch (CommandMatchException $e)
        {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * @param array $commandArray
     * @return void
     */
    private function initializeStatusValue(array $commandArray): void
    {
        # First, code detects which type of command it will do, then it proceeds with its parameters.
        switch ($commandArray["command_name"])
        {
            case 'Index':
                $this->status = CommandNames::Index;
                # in this case, we initialize the parameters for the Index command.
                $this->initializeListParameters($commandArray);
                # code begins to index everything:
                $this->showPages();
                break;

            case 'Get':
                $this->status = CommandNames::Get;
                # in this case, we initialize the parameters for the Get command.
                $this->initializeGetParameters($commandArray);
                $this->showSelectedBook();
                break;

            case 'Create':
                $this->status = CommandNames::Create;
                # in this case, we initialize the parameters for the Add command.
                $this->initializeAddParameters($commandArray);
                $this->createBook($commandArray["parameters"]["addTo"]);
                break;

            case 'Delete':
                $this->status = CommandNames::Delete;
                # in this case, we initialize the parameters for the Delete command.
                $this->initializeDeleteParameters($commandArray);
                $this->deleteBook();
                break;

            case 'Update':
                $this->status = CommandNames::Update;
                # in this case, we initialize the parameters for the Update command.
                $this->initializeUpdateParameters($commandArray);
                $this->updateBook();
                break;
        }
    }

    /**
     * @param array $commandArray
     * @return void
     */
    private function initializeListParameters(array $commandArray): void
    {
        
    /*
        first, code creates an array to validate the type of parameters for the List command and
        if its successful, code then proceed with validating the values for the List command parameters.
    */
        # An array to store parameter values whilst code validates them.
        $parametersArray =
            [
            "pageNumber" => $commandArray["parameters"]["pageNumber"],
            "perPage" => $commandArray["parameters"]["perPage"],
            "sort" => $commandArray["parameters"]["sort"],
            "filterByAuthor" => $commandArray["parameters"]["filterByAuthor"]
            ];

        try
        {
            $validateParameters = new ListCommandParameterValidator();
            # Validating the List command parameter's types.
            $validateParameters->validateCommandParametersTypes($parametersArray);
            # Validating the List command parameter's values.
            $validateParameters->validateParametersValue($parametersArray);
        }
        catch (InvalidListCommandParametersException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new ListCommandParameters
        (
            pageNumber: $parametersArray["pageNumber"],
            perPage: $parametersArray["perPage"],
            sort: $parametersArray["sort"],
            filterByAuthor: $parametersArray["filterByAuthor"]
        );
    }
    private function initializeGetParameters(array $commandArray): void
    {

    /*
        first, We create an array to validate the type of parameters for the Get command and
        if its successful, we then proceed with validating the values for the Get command parameters
    */
        $parametersArray = ["ISBN" => $commandArray["parameters"]["ISBN"]];
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
        $this->parameters = new GetCommandParameters(ISBN: $parametersArray["ISBN"]);
    }
    private function initializeAddParameters(array $commandArray): void
    {
        try {
            $validateParameters = new AddCommandParameterValidator();

            # First we validate the file format:
            $validateParameters->validateAddToParameter($commandArray["parameters"]["addTo"]);

            # We then proceed to validate the parameter's types:
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
    private function initializeDeleteParameters(array $commandArray): void
    {
        /*
        first, We create an array to validate the type of parameters for the Delete command and
        if its successful, we then proceed with validating the values for the Delete command parameters
        */
        $parametersArray = ["ISBN" => $commandArray["parameters"]["ISBN"]];
        try {
            $validateParameters = new DeleteCommandParameterValidator();
            $validateParameters->validateCommandParametersTypes($parametersArray);
            # Validating the List command parameter's values.
            $validateParameters->validateParametersValue($parametersArray);
        } catch (InvalidDeleteCommandParametersException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new DeleteCommandParameters(ISBN: $parametersArray["ISBN"]);
    }
    private function initializeUpdateParameters(array $commandArray): void
    {
        try {

            # We proceed to validate the parameter's types:
            $validateParameters = new UpdateCommandParameterValidator();
            $validateParameters->validateCommandParametersTypes($commandArray);

            # then we proceed to validate the parameter's values:
            $validateParameters->validateParametersValue($commandArray);

        } catch (InvalidUpdateCommandParametersException $e)
        {
            echo $e->getMessage();
            exit();
        }

        # Initializing the $parameters property for the CommandRead class.
        $this->parameters = new UpdateCommandParameters
        (
            ISBN: $commandArray["parameters"]["ISBN"],
            bookTitle: $commandArray["parameters"]["bookTitle"],
            authorName: $commandArray["parameters"]["authorName"],
            pagesCount: $commandArray["parameters"]["pagesCount"],
            publishDate: $commandArray["parameters"]["publishDate"]
        );
    }
    private function showPages(): void
    {
        # Transferring the parameters to another class responsible for indexing the books.
        $showPages = new ShowPages
        (
            $this->parameters->getPageNumber(),
            $this->parameters->getPerPage(),
            $this->parameters->getSort(),
            $this->parameters->getFilterByAuthor()
        );
        # code asks this method from ShowPages class to apply the Indexing.
        $showPages->applyOperator();
    }
    private function showSelectedBook():void
    {
        /*
        Given that now we have all the parameters we need, we begin showing the book selected by user by
        creating a property from ShowSelectedPage class and using it to do so.
        */
        $showSelectedBook = new ShowSelectedBook($this->parameters->getISBN());
        $showSelectedBook->applyOperator();
    }
    private function createBook(string $addTo): void
    {
        $createBook = new CreateBook
        (
            ISBN: $this->parameters->getISBN(),
            bookTitle: $this->parameters->getBookTitle(),
            authorName: $this->parameters->getAuthorName(),
            pagesCount: $this->parameters->getPagesCount(),
            publishDate: $this->parameters->getPublishDate(),
            addTo: $addTo
        );
        $createBook->applyOperator();
    }
    private function deleteBook(): void
    {
        /*
        Given that now we have all the parameters we need, we begin deleting the book selected by user by
        creating a property from DeleteBook class and using it to do so.
        */
        $deleteBook = new DeleteBooks($this->parameters->getISBN());
        $deleteBook->applyOperator();
        echo "Book Deleted Successfully!";
    }
    private function updateBook():void
    {
        $updateBook = new UpdateBook
        (
            ISBN: $this->parameters->getISBN(),
            bookTitle: $this->parameters->getBookTitle(),
            authorName: $this->parameters->getAuthorName(),
            pagesCount: $this->parameters->getPagesCount(),
            publishDate: $this->parameters->getPublishDate(),
        );
        $updateBook->applyOperator();
    }
}