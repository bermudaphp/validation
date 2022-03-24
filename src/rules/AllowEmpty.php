<?php

namespace Bermuda\Validation\Rules;

final class AllowEmpty implements RuleInterface
{
    public function __construct(private RuleInterface $nextRule) {
    }

    /**
     * @param $value
     * @return bool|string|array
     */
    public function validate($value): bool|string|array
    {
        if (empty($value)) {
            return true;
        }
        
        return $this->nextRule->validate($value);
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'allowEmpty';
    }
}
