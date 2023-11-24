<?php

namespace assignment\Validators\CommandParameterValidator;
use assignment\CommandParameters\ListCommandParameters;

interface CommandParameterValidator
{
    public function validateParametersValue(array $parametersArray): void;
    public function validateCommandParametersTypes(array $parametersArray): void;
}
