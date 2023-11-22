<?php

namespace assignment\Validators;
use assignment\CommandParameters\ListCommandParameters;

interface CommandParameterValidator
{
    public function validateParametersValue(array $parametersArray): void;
    public function validateCommandParametersTypes(array $parametersArray): void;
}
