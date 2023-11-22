<?php
declare(strict_types=1);
namespace assignment\Manager;

class ViewList
{
    public function __construct(
        private int $pageNumber,
        private int $perPage,
        private string $sort,
        private string $filterByAuthor,
        private array $books
    )
    {
        # Before showing the list, First we sort it by the sort user requested:
        $this->sortByPublishDate();

        # then we filter the list by Author's name:
        $booksList = $this->filterByAuthor();

        # Now it's time to show the results. First we calculate which books we're showing according to settings:
        $calculatedItems = $this->calculateItems($booksList);

        # Now we Show it using HTML & CSS:
        $this->showResults($calculatedItems, $booksList);
    }

    private function filterByAuthor(): array
    {
        $booksList = [];
        if ($this->filterByAuthor === "")
        {
            return $this->books;
        }
        for ($i = 0; $i < sizeof($this->books); $i++)
        {
            if ($this->books[$i]->getAuthorName() === $this->filterByAuthor)
                {
                    $booksList[] = $this->books[$i];
                }
        }
        return $booksList;
    }

    private function sortByPublishDate(): void
    {
        usort($this->books, callback: array($this, 'comparePublishDates'));
    }

    private function comparePublishDates($bookOne, $bookTwo): int
    {
        $publishDateBookOne = strtotime($bookOne->getPublishDate());
        $publishDateBookTwo = strtotime($bookTwo->getPublishDate());

        if ($this->sort === "Descending")
            return ($publishDateBookTwo - $publishDateBookOne);

        return ($publishDateBookOne - $publishDateBookTwo);
    }

    private function calculateItems(array $booksList): array
    {
        $calculatedItems = [];
        $startingBookIndex = ($this->pageNumber * $this->perPage) - $this->perPage;
        $endingBookIndex = ($this->pageNumber * $this->perPage);
        for ($i = $startingBookIndex; $i < $endingBookIndex; $i++)
        {
            # if array key is not defined, we simply will not include it in out $calculatedItems[] array.
            if (isset($booksList[$i]))
            {
                $calculatedItems[] = $booksList[$i];
            }
            else
                continue;
        }
        return $calculatedItems;
    }

    private function showResults(array $calculatedItems, array $booksList): void
    {
        $numberOfPages = sizeof($booksList) / $this->perPage;
        $numberOfPages = ceil($numberOfPages);
        echo 'Showing Results for Page ' . $this->pageNumber . ' of ' . $numberOfPages . ': ' . '</br>' . '</br>';
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

        foreach ($calculatedItems as $book) {
            echo '<tr>';
            echo '<td>' . $book->getISBN() . '</td>';
            echo '<td>' . $book->getBookTitle() . '</td>';
            echo '<td>' . $book->getAuthorName() . '</td>';
            echo '<td>' . $book->getPagesCount() . '</td>';
            echo '<td>' . $book->getPublishDate() . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}