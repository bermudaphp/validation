<?php

namespace Bermuda\Validation\Rules;

final class AllOf implements RuleCollectionInterface
{
    use RuleCollectionTrait;

    /**
     * @inerhitDoc
     */
    public function validate($value): bool|string|array
    {
        $messages = [];
        foreach ($this->rules as $rule) {
            if (($result = $rule->validate($value)) !== true) {
                $messages[] = $result;
            }
        }
        
        if (($count = count($messages)) == 1) {
            return $messages[0];
        }

        return $count > 0 ? $messages : true;
    }
    
    public function getName(): string 
    {
        return 'allOf';
    }
}
