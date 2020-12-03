<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Trait RuleTrait
 * @package App\Validator\Rules
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
     * @param array|null $result
     * @param $value
     * @return array
     */
    private function validateNext($value, ?array $result = []): array
    {
        if ((array) $result == [] && $this->next != null)
        {
            return ($this->next)($value);
        }

        return (array) $result;
    }
}