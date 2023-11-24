<?php

namespace assignment\Manager\Operator;

use assignment\database\Classes\{AddBookDTO, WriteOntoCsv, WriteOntoJson};
use assignment\Manager\ViewCreated;

class CreateBook implements StandardOperator
{
    public function __construct
    (
        private string $ISBN = '',
        private string $bookTitle = '',
        private string $authorName = '',
        private int $pagesCount = 0,
        private string $publishDate = '',
        private string $addTo = ''
    )
    {}

    public function applyOperator(): void
    {
        # Transfers Book's info to DTO
        $DTO = $this->transferInfoToDTO();
        switch ($this->addTo)
        {
            case 'json':
                $writeOntoDataBase = new WriteOntoJson($DTO);
                break;
            case 'csv':
                $writeOntoDataBase = new WriteOntoCsv($DTO);
                break;
        }
        $this->addToAuthorsJson();

        # Showing the added book:
        $viewCreated = new ViewCreated($DTO);
    }
    private function transferInfoToDTO(): AddBookDTO
    {
        $DTO = new AddBookDTO
        (
            ISBN: $this->ISBN,
            bookTitle: $this->bookTitle,
            authorName: $this->authorName,
            pagesCount: $this->pagesCount,
            publishDate: $this->publishDate,
            addTo: $this->addTo
        );
        return $DTO;
    }
    private function addToAuthorsJson()
    {
        # Reading from authors.json
        $authorsArray = json_decode(file_get_contents('assignment/database/authors.json'), true);

        # Adding new author to the index
        $authorsArray["authors"][] = $this->authorName;

        # Encoding the updated authors index back to JSON and Writing the updated JSON string back to the file
        file_put_contents('assignment/database/authors.json', json_encode($authorsArray, JSON_PRETTY_PRINT));
    }
}