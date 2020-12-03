<?php

namespace Bermuda\Validation\Rules;


/**
 * Trait RuleTrait
 * @package Bermuda\Validation\Rules
 */
trait RuleTrait
{
    private ?RuleInterface $next = null;

    /**
     * @param RuleInterface|null $rule
     * @return RuleInterface|null
     */
    public function setNext(?RuleInterface $rule):? RuleInterface
    {
        return $this->next = $rule;
    }

    /**
     * @param array $result
     * @param $value
     * @return array
     */
    private function validateNext($value, array $result = []): array
    {
        if ($result == [] && $this->next != null)
        {
            return ($this->next)($value);
        }

        return $result;
    }
}
