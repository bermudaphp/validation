<?php

namespace Bermuda\Validation\Rules;

/**
 * Trait RuleTrait
 * @package Bermuda\Validation\Rules
 */
trait RuleTrait
{
    protected ?RuleInterface $next = null;

    /**
     * @param RuleInterface|null $rule
     * @return $this
     */
    public function setNext(?RuleInterface $rule): RuleInterface
    { 
        $this->next != null && $rule != null ? 
            $this->next->setNext($rule) : 
            $this->next = $rule;
        
        return $this;
    }

    /**
     * @param array $result
     * @param $value
     * @return array
     */
    protected function validateNext($value): array
    {
        if ($this->next != null)
        {
            return ($this->next)($value);
        }

        return [];
    }
}
