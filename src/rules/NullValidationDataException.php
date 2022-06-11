<?php

namespace Bermuda\Validation\Rules;

final class NullValidationDataException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Validation data is null');
    }
}
