<?php

declare(strict_types=1);
namespace assignment\database\Classes;

class ReadDataBase
{
    /*
     * There are 3 properties for this class which reads the Books database.
     * First one is $allData which stores all data read from both .csv and .json files.
     * Second one is $csvData which stores all data read from books.csv file.
     * Third one is $jsonData which stores all data read from books.csv file.
     * Later in the code, $jsonData and $csvData will merge into $allData.
     */
    public function __construct
    (
        private array $allData = [],
        private array $csvData = [],
        private array $jsonData = []
    )
    {
        # at this stage, code reads from the dataBase with the following codes:
        $readFromJson = new ReadFromJson();
        $readFromCsv = new ReadFromCsv();

        # Storing the Data read from Database into the properties of this class.
        $this->jsonData = $readFromJson->readFromDataBase();
        $this->csvData = $readFromCsv->readFromDataBase();

        # now code merges the data it got from both .json and .csv file through another class named: MergeData.
        $mergeData = new MergeData(csvData: $this->csvData, jsonData: $this->jsonData);
        $this->allData = $mergeData->getMergedData();
    }


    # Getter functions to get the database to different sections of the code as they need it.
    public function getAllData(): array
    {
        return $this->allData;
    }

    public function getCsvData(): array
    {
        return $this->csvData;
    }

    public function getJsonData(): array
    {
        return $this->jsonData;
    }
}


