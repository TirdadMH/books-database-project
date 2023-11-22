<?php
declare(strict_types=1);
namespace assignment\Manager;

use assignment\Exceptions\InvalidGetCommandParametersException;

class ViewSelected
{
    public function __construct(private string $ISBN, private array $books)
    {
        $this->showBook($this->findBook());
    }

    private function findBook(): int
    {
        for ($i = 0; $i < sizeof($this->books); $i++)
        {
            if ($this->ISBN === $this->books[$i]->getISBN())
                return $i;
        }
        return -1;
    }

    private function showBook(int $selectedBookIndex)
    {
        if ($selectedBookIndex < 0)
        {
            echo "Book Not Found!";
            exit();
        }
        echo 'Showing Result for Selected Book: ' . '</br>' . '</br>';
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
            echo '<td>' . $this->books[$selectedBookIndex]->getISBN() . '</td>';
            echo '<td>' . $this->books[$selectedBookIndex]->getBookTitle() . '</td>';
            echo '<td>' . $this->books[$selectedBookIndex]->getAuthorName() . '</td>';
            echo '<td>' . $this->books[$selectedBookIndex]->getPagesCount() . '</td>';
            echo '<td>' . $this->books[$selectedBookIndex]->getPublishDate() . '</td>';
            echo '</tr>';

        echo '</table>';
    }
}