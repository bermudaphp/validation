<?php

namespace Bermuda\Validation\Rules;


/**
 * Class NotEmpty
 * @package Bermuda\Validation\Rules
 */
final class NotEmpty extends AbstractRule
{
    /**
     * @param $value
     * @return bool
     */
    protected function validate(&$value): bool
    {
        return !empty($value);
    }
    
     /**
     * @param $value
     * @return array
     */
    protected function getMessageFor($value): string
    {
        return 'Must be not empty';
    }
}
