<?php

namespace Bermuda\Validation\Rules;

use Generator;

final class OneOf implements RuleCollectionInterface
{
    use RuleCollectionTrait;

    /**
     * @param $value
     * @return bool|string
     */
    public function validate($value): bool|string
    {
        foreach ($this->rules as $rule) {
            if (($result = $rule->validate($value)) === true) {
                return true;
            }
        }

        return $result;
    }
    
    public function getName(): string 
    {
        return 'oneOf';
    }
}
