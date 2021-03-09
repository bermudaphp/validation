<?php

namespace Bermuda\Validation\Rules;

/**
 * Class Number
 * @package Bermuda\Validation\Rules
 */
class Number extends AbstractRule
{
   /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return is_numeric($value);
    }
    
    /**
     * @inheritDoc
     */
    protected function getDefaultMessage(): string
    {
        return 'Must be a number';
    }
}
