<?php
namespace assignment\Manager\Enums;
enum CommandNames: int
{
    case Index = 1;
    case Get = 2;
    case Create = 3;
    case Delete = 4;
    case Update = 5;
}