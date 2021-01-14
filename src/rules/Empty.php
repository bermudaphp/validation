<?php

namespace Bermuda\Validation\Rules;


/**
 * Class Empty
 * @package Bermuda\Validation\Rules
 */
final class Empty extends AbstractRule
{
    /**
     * @param $value
     * @return bool
     */
    protected function validate($value): bool
    {
        return empty($value);
    }
    
     /**
     * @param $value
     * @return array
     */
    protected function getMessageFor($value): array
    {
        return ['Must be empty'];
    }
}
