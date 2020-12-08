<?php

namespace Bermuda\Validation\Rules;


/**
 * Class NotEmpty
 * @package Bermuda\Validation\Rules
 */
final class Empty implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return empty($value) ? $this->validateNext($value) : ['The value must be empty'];
    }
}
