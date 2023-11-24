<?php

namespace assignment\database\Classes;

class MergeData
{
    public function __construct(
        private array $csvData,
        private array $jsonData,
        private array $mergedData = []
    )
    {
        $this->mergedData = array_merge($csvData, $jsonData);
    }

    # a Getter method for mergedData property.
    public function getMergedData(): array
    {
        return $this->mergedData;
    }
}
