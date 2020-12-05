<?php

namespace Bermuda\Validation;


/**
 * Class ValidationException
 * @package Bermuda\Validation
 */
class ValidationException extends \RuntimeException
{
    protected array $errors = [];

    public function __construct(array $stack, array $errors)
    {
        $this->file = $stack['file'];
        $this->line = $stack['line'];

        $this->errors = $errors;
        parent::__construct($this->stackToSring($stack));
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    /**
     * @param array $stack
     * @return string
     */
    private function stackToSring(array $stack): string
    {
        return $stack['class'] . '::' . $stack['function'] . ' failed validation!';
    }
}
