<?php

namespace Bermuda\Validation\Rules;

final class AllOf extends OneOf
{
    /**
     * @inerhitDoc
     */
    public function validate($value): bool|string
    {
        foreach ($this->rules as $rule) {
            if (($result = $rule->validate($value)) !== true) {
                return $result;
            }
        }

        return $this->validateNext($value);
    }
}
