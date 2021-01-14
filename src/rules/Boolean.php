<?php

namespace Bermuda\Validation\Rules;


use function Bermuda\str_equals_any;


/**
 * Class Boolean
 * @package Bermuda\Validation\Rules
 */
final class Boolean extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected function validate($value): bool
    {
        return is_bool($value) || (is_numeric($value) && ($value == 1 || $value == 0)) 
            || (is_string($value) && str_equals_any($value, ['on', 'off'], true));
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): array
    {
        return ['Must be boolean or equal to any of: 1, 0, on, off!'];
    }
}
