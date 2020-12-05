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
    
    public function __construct(array $prev_call, array $errors)
    {
        $this->errors = $errors;
        
        $this->file = $prev_call['file'];
        $this->line = $prev_call['line'];
        $this->class = $prev_call['class']

        parent::__construct($this->prevToSring($prev_call));
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
    private function prevToSring(array $stack): string
    {
        return $stack['class'] . '::' . $stack['function'] . ' failed validation!';
    }
}
