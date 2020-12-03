<?php

namespace Bermuda\Validation\Rules;


use function Bermuda\str_equals_any;


/**
 * Class Boolean
 * @package Bermuda\Validation\Rules
 */
class Boolean implements RuleInterface
{
    use RuleTrait;

    /**
     * @inheritDoc
     */
    public function __invoke($value): array
    {
        return is_bool($value) || (is_numeric($value) && ($value == 1 || $value == 0)) 
            || (is_string($value) && str_equals_any($value, ['on', 'off'], true)) 
            ? $this->validateNext($value) : 
        ['The value must be boolean or equal to any of: 1, 0, on, off!'];
    }
}
