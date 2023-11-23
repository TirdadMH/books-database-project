<?php

declare(strict_types=1);
namespace assignment\database\Classes;

class ReadDataBase
{
    public function __construct
    (
        private array $allData = [],
        private array $csvData = [],
        private array $jsonData = []
    )
    {
        # at this stage, we read from the dataBase with the following codes:
        $readFromJson = new ReadFromJson();
        $readFromCsv = new ReadFromCsv();
        $this->jsonData = $readFromJson->readFromDataBase();
        $this->csvData = $readFromCsv->readFromDataBase();

        # now we merge the data we got from both .json and .csv file:
        $mergeData = new MergeData(csvData: $this->csvData, jsonData: $this->jsonData);
        $this->allData = $mergeData->getMergedData();
    }

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


