<?php

namespace assignment\database\Classes;

/*
 * This interface, will determine what functions should ReadFromJson and ReadFromCsv classes must have.
 */
interface ReadFromDatabase
{
    public function __construct();
    public function readFromDataBase(): array;
}