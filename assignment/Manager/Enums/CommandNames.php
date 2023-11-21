<?php
namespace assignment\Manager\Enums;
enum CommandNames: int
{
    case List = 1;
    case Get = 2;
    case Add = 3;
    case Delete = 4;
    case Update = 5;
}