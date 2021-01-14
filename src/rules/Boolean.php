<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\Str;

/**
 * Class Boolean
 * @package Bermuda\Validation\Rules
 */
final class Boolean extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return Str::equalsAny($value, ['on', 'off', '1', '0'], true);
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be equal to any of: 1, 0, on, off!';
    }
}
