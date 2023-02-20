<?php

namespace Bermuda\Validation;

interface ValidatorInterface
{
    /**
     * @param array $data
     * Throws an ValidationException if validation fails
     * @throws ValidationException
     */
    public function validate(array $data): void ;
}
