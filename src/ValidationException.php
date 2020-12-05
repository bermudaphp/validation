<?php

namespace Bermuda\Validation;


/**
 * Class ValidationException
 * @package Bermuda\Validation
 */
final class ValidationException extends \RuntimeException
{
    private ?string $class;
    private string $funcName;
    private array $errors = [];
    
    public function __construct(array $prev_call, array $errors)
    {
        $this->errors = $errors;
        
        $this->file = $prev_call['file'];
        $this->line = $prev_call['line'];
        $this->class = $prev_call['class'] ?? null;
        $this->funcName = $prev_call['function'];

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
     * Return validator class name
     * @return string|null
     */
    public function getClass():? string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getFunctionName(): string
    {
        return $this->funcName;
    }
   
    /**
     * @param array $stack
     * @return string
     */
    private function prevToSring(array $stack): string
    {
        if (!isset($stack['class']))
        {
            return $stack['function'] . ' failed validation!';
        }

        return $stack['class'] . '::' . $stack['function'] . ' failed validation!';
    }
}
