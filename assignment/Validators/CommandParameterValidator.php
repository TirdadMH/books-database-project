<?php

namespace assignment\Validators;
use assignment\Command_Parameters\ListCommandParameters;

interface CommandParameterValidator
{
    public function validateParametersValue(array $parametersArray): void;
    public function validateCommandParametersTypes(array $parametersArray): void;
}
