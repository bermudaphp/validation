<?php

namespace Bermuda\Validation;

interface ValidatorInterface
{
    /**
     * @param array $data
     * @throws ValidationException
     * Throws an ValidationException if validation fails
     */
    public function validate(array $data): void ;
}
