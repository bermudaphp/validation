<?php

namespace Bermuda\Validation\Rules;


/**
 * Class NotEmpty
 * @package Bermuda\Validation\Rules
 */
final class NotEmpty implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return !empty($value) ? [] : ['The value must not be empty!'];
    }
}
