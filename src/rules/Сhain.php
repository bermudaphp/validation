<?php

namespace Bermuda\Validation\Rules;

final class Сhain implements RuleCollectionInterface
{
    use RuleCollectionTrait;
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
        
        return true;
    }

    public function getName(): string
    {
        return 'chain';
    }
}
