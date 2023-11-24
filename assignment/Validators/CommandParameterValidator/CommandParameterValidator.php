<?php

namespace assignment\Validators\CommandParameterValidator;
use assignment\CommandParameters\ListCommandParameters;

# Every single command parameters validators have the exact methods according to this interface.
interface CommandParameterValidator
{
    public function validateParametersValue(array $parametersArray): void;
    public function validateCommandParametersTypes(array $parametersArray): void;
}
