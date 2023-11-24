<?php

namespace assignment\Manager;

use assignment\database\Classes\AddBookDTO;

class ViewCreated
{
    public function __construct(private AddBookDTO $DTO)
    {
        $this->showMessage();
    }
    private function showMessage(): void
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
        echo '<td>' . $this->DTO->getISBN() . '</td>';
        echo '<td>' . $this->DTO->getBookTitle() . '</td>';
        echo '<td>' . $this->DTO->getAuthorName() . '</td>';
        echo '<td>' . $this->DTO->getPagesCount() . '</td>';
        echo '<td>' . $this->DTO->getPublishDate() . '</td>';
        echo '</tr>';
        echo '</table>';
    }
}