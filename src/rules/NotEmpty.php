<?php


namespace Bermuda\Validation\Rules;


/**
 * Class NotEmpty
 * @package Bermuda\Validation\Rules
 */
final class NotEmpty implements RuleInterface
{
    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        return !empty($value) ? [] : ['The value must not be empty!'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'notEmpty';
    }
}
