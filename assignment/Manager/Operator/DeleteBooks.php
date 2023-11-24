<?php
declare(strict_types=1);
namespace assignment\Manager\Operator;

use assignment\database\Classes\ReadDataBase;

class DeleteBooks implements StandardOperator, GetIndex
{
    use UpdateDataBaseFiles;
    public function __construct(private string $ISBN = "")
    {}
    public function applyOperator(): void
    {
        # First thing first: we read from Data Base:
        $books = new ReadDataBase();

        # Now we get all the read data:
        $csvData = $books->getCsvData();
        $jsonData = $books->getJsonData();

        # Getting index of the book we need to soft-delete:
        $index0fJson = $this->getISBNIndex($jsonData);
        $index0fCsv = $this->getISBNIndex($csvData);

        if ($index0fCsv === -1 && $index0fJson !== -1)
        {
            # Now we Delete:
            $jsonData = $this->deleteBook($index0fJson, $jsonData, false);

            # Updating the books.json:
            $this->updateJsonFile($jsonData);
        }
        else if ($index0fCsv !== -1 && $index0fJson === -1)
        {
            # Now we Delete:
            $csvData = $this->deleteBook($index0fCsv, $csvData, true);

            # Updating the books.csv:
            $this->updateCsvFile($csvData);

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
                if ($data[$i]["soft-deleted"] === "1")
                {
                    echo "Book Not Found!";
                    exit();
                }
                else
                    return $i;
            }
        }
        return -1;
    }
    private function deleteBook(int $index, array $data, bool $isCSV): array
    {
        if ($isCSV)
            $data[$index]["soft-deleted"] = 1;
        else $data[$index]["soft-deleted"] = true;
        return $data;
    }
}