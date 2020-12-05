<?php

namespace Bermuda\Validation;


/**
 * Class ValidationException
 * @package Bermuda\Validation
 */
final class ValidationException extends \RuntimeException
{
    private string $class;
    private array $errors = [];
    
    public function __construct(array $stack, array $errors)
    {
        $this->errors = $errors;
        
        $this->file = $stack['file'];
        $this->line = $stack['line'];
        $this->class = $stack['class']

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
     * @return string
     */
    public function getValidatorClass(): string
    {
        return $this->class;
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
