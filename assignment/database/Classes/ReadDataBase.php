<?php

declare(strict_types=1);
namespace assignment\database\Classes;

class ReadDataBase
{
    public function __construct(private array $allData = [])
    {
        # at this stage, we read from the dataBase with the following codes:
        $readFromJson = new ReadFromJson();
        $readFromCsv = new ReadFromCsv();
        $csvData = $readFromJson->readFromDataBase();
        $jsonData = $readFromCsv->readFromDataBase();

        # now we merge the data we got from both .json and .csv file:
        $mergeData = new MergeData(csvData: $csvData, jsonData: $jsonData);
        $this->allData = $mergeData->getMergedData();
    }

    public function getAllData(): array
    {
        return $this->allData;
    }
}


