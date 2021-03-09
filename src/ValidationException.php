<?php

namespace Bermuda\Validation;

/**
 * Class ValidationException
 * @package Bermuda\Validation
 */
class ValidationException extends \RuntimeException
{
    protected ?string $class;
    protected string $funcName;
    protected array $errors = [];
    
    public function __construct(array $stack, array $errors)
    {
        $this->errors = $errors;
        
        $this->file = $stack['file'];
        $this->line = $stack['line'];
        $this->class = $stack['class'] ?? null;
        $this->funcName = $stack['function'];

        parent::__construct($this->stackToSring($stack), 400);
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
    protected function stackToSring(array $stack): string
    {
        if (!isset($stack['class']))
        {
            return $stack['function'] . ' failed validation!';
        }

        return $stack['class'] . '::' . $stack['function'] . ' failed validation!';
    }
}
