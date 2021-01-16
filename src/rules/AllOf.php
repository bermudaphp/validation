<?php

namespace Bermuda\Validation\Rules;

/**
 * Class AllOf
 * @package Bermuda\Validation\Rules
 */
final class AllOf extends OneOf
{
    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        foreach ($this->rules as $rule)
        {
            if (($msg = $rule($value)) != [])
            {
                return $msg;
            }
        }

        return $this->validateNext($value);
    }
}
