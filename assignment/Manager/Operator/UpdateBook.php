<?php
declare(strict_types=1);
namespace assignment\Manager\Operator;

use assignment\database\Classes\ReadDataBase;
use assignment\Manager\ViewUpdated;

class UpdateBook implements StandardOperator, GetIndex
{
    use UpdateDataBaseFiles;
    public function __construct
    (
        private string $ISBN = '',
        private string $bookTitle = '',
        private string $authorName = '',
        private int $pagesCount = 0,
        private string $publishDate = '',
    )
    {}
    public function applyOperator(): void
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $csvData = $books->getCsvData();
        $jsonData = $books->getJsonData();

        # Getting index of the book we need to Update:
        $index0fJson = $this->getISBNIndex($jsonData);
        $index0fCsv = $this->getISBNIndex($csvData);

        if ($index0fCsv === -1 && $index0fJson !== -1)
        {
            # Now we Update the books.json:
            $jsonData = $this->updateBook($index0fJson, $jsonData);

            # Updating the books.json:
            $this->updateJsonFile($jsonData);

            # Showing user the Updated Book:
            $viewUpdated = new ViewUpdated($index0fJson, $jsonData);
        }
        else if ($index0fCsv !== -1 && $index0fJson === -1)
        {
            # Now we Update:
            $csvData = $this->updateBook($index0fCsv, $csvData);

            # Updating the books.csv:
            $this->updateCsvFile($csvData);

            # Showing user the Updated Book:
            $viewUpdated = new ViewUpdated($index0fCsv, $csvData);
        }
        else if ($index0fCsv === -1 && $index0fJson === -1)
        {
            echo "Book Not Found!";
            exit();
        }
    }


    function getISBNIndex(array $data): int
    {
        for ($i = 0; $i < sizeof($data); $i++)
        {
            if ($this->ISBN === $data[$i]["ISBN"])
            {
                return $i;
            }
        }
        return -1;
    }
    private function updateBook(int $index0fJson, array $jsonData): array
    {
        if ($this->bookTitle !== "")
            $jsonData[$index0fJson]["bookTitle"] = $this->bookTitle;
        if ($this->authorName !== "")
            $jsonData[$index0fJson]["authorName"] = $this->authorName;
        if ($this->pagesCount !== 0)
            $jsonData[$index0fJson]["pagesCount"] = $this->pagesCount;
        if ($this->publishDate !== "")
            $jsonData[$index0fJson]["publishDate"] = $this->publishDate;
        return $jsonData;
    }
}