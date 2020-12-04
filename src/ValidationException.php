<?php


namespace Bermuda\Validation;


/**
 * Class ValidationException
 * @package Bermuda\Validation
 */
class ValidationException extends \RuntimeException
{
    protected array $errors = [];

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation is failed!');
    }
    
    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
