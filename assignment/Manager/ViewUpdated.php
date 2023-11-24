<?php

namespace assignment\Manager;

class ViewUpdated
{
    public function __construct(private int $index, private array $data)
    {
        $this->showUpdated();
    }
    private function showUpdated()
    {
        echo 'the Following Book Updated Successfully: ' . '</br>' . '</br>';
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
        echo '<td>' . $this->data[$this->index]["ISBN"] . '</td>';
        echo '<td>' . $this->data[$this->index]["bookTitle"] . '</td>';
        echo '<td>' . $this->data[$this->index]["authorName"] . '</td>';
        echo '<td>' . $this->data[$this->index]["pagesCount"] . '</td>';
        echo '<td>' . $this->data[$this->index]["publishDate"] . '</td>';
        echo '</tr>';
        echo '</table>';
    }
}