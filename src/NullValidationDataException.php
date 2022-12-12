<?php

namespace Bermuda\Validation;

final class NullValidationDataException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Validation data is null');
    }
}
