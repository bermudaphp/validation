<?php

namespace Bermuda\Validation\Rules;

use Generator;

final class OneOf implements RuleCollectionInterface
{
    use RuleCollectionTrait;

    /**
     * @inheritDoc
     */
    public function validate($value): bool|string|array
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
