<?php

namespace assignment\Manager\Operator;

use assignment\database\Classes\{AddBookDTO, WriteOntoCsv, WriteOntoJson};

class CreateBook
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

    public function applyCreate(): void
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
        $this->showMessage($DTO);
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
    private function showMessage(AddBookDTO $DTO)
    {
        echo 'the Following Book Added Successfully: ' . '</br>' . '</br>';
        echo '<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>';

        echo '<table>
        <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
            <th>Pages</th>
            <th>Publish Date</th>
        </tr>';
            echo '<tr>';
            echo '<td>' . $DTO->getISBN() . '</td>';
            echo '<td>' . $DTO->getBookTitle() . '</td>';
            echo '<td>' . $DTO->getAuthorName() . '</td>';
            echo '<td>' . $DTO->getPagesCount() . '</td>';
            echo '<td>' . $DTO->getPublishDate() . '</td>';
            echo '</tr>';
        echo '</table>';
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