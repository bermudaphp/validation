<?php

namespace Bermuda\Validation\Rules;

/**
 * Class NotEmpty
 * @package Bermuda\Validation\Rules
 */
final class Required extends NotEmpty
{
    /**
     * @param $value
     * @return array
     */
    protected function getMessageFor($value): string
    {
        return 'is required';
    }
}
