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

        # then code filters the list by Author's name. if the "filterByAuthor" field is empty, no filter will apply.
        $booksList = $this->filterByAuthor();

        /*
         * Now it's time to show the results.
         * First code calculates which books it's showing according to pageNumber and perPage settings:
         */
        $calculatedItems = $this->calculateItems($booksList);

        # Now we Show it using HTML & CSS:
        $this->showResults($calculatedItems, $booksList);
    }

    /**
     * @return array: this array is the list of filtered books.
     */
    private function filterByAuthor(): array
    {
        $booksList = [];
        $isBooksListEmpty = true;
        if ($this->filterByAuthor === "")
        {
            # If there's no filter given, main array of books will return.
            return $this->books;
        }
        for ($i = 0; $i < sizeof($this->books); $i++)
        {
            if ($this->books[$i]->getAuthorName() === $this->filterByAuthor)
                {
                    $isBooksListEmpty = false;
                    $booksList[] = $this->books[$i];
                }
        }

        # If the Given filter does not match with anyone, main array of books will return.
        if ($isBooksListEmpty)
            return $this->books;

        # Returning the filtered array of books.
        return $booksList;
    }

    private function sortByPublishDate(): void
    {
        usort($this->books, callback: array($this, 'comparePublishDates'));
    }

    /**
     * @param $bookOne
     * @param $bookTwo
     * @return int
     * This is a Callback function that gets the publishing time of books and subtracts them from each other.
     * If the result is a positive number, book with an older publish date gets indexed first.
     */
    private function comparePublishDates($bookOne, $bookTwo): int
    {
        $publishDateBookOne = strtotime($bookOne->getPublishDate());
        $publishDateBookTwo = strtotime($bookTwo->getPublishDate());

        if ($this->sort === "Descending")
            return ($publishDateBookTwo - $publishDateBookOne);

        return ($publishDateBookOne - $publishDateBookTwo);
    }

    /**
     * @param array $booksList
     * @return array
     */
    private function calculateItems(array $booksList): array
    {
        # This array stores the books in the specific pageNumber and perPage row.
        $calculatedItems = [];

        $startingBookIndex = ($this->pageNumber * $this->perPage) - $this->perPage;
        $endingBookIndex = ($this->pageNumber * $this->perPage);
        for ($i = $startingBookIndex; $i < $endingBookIndex; $i++)
        {
            # if array key is not defined, we simply will not include it in $calculatedItems[] array.
            if (isset($booksList[$i]))
            {
                $calculatedItems[] = $booksList[$i];
            }
            else
                continue;
        }
        return $calculatedItems;
    }

    /**
     * @param array $calculatedItems
     * @param array $booksList
     * @return void
     */
    private function showResults(array $calculatedItems, array $booksList): void
    {
        # First, Code rounds the number of pages, since we can not have for example 6.5 pages.
        $numberOfPages = sizeof($booksList) / $this->perPage;
        $numberOfPages = ceil($numberOfPages);

        # Now It's time to style the indexes with some HTML and CSS:
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

        # Indexing the books.
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