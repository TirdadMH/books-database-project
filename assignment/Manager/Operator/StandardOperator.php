<?php

namespace assignment\Manager\Operator;

interface StandardOperator
{
    public function __construct();
    public function applyView(): void;
}