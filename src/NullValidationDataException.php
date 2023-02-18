<?php

namespace Bermuda\Validation;

final class NullValidationDataException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Validation data is null');
    }
}
