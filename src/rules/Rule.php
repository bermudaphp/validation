<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Rule
 * @package App\Validator\Rules
 */
class Rule
{
    /**
     * @param RuleInterface $rule
     * @param RuleInterface ...$rules
     * @return RuleInterface
     */
    public static function chain(RuleInterface $rule, RuleInterface ... $rules): RuleInterface
    {
        $current = $rule;

        while (($next = array_shift($rules)) != null)
        {
            $current->setNext($next);
            $current = $next;
        }

        return $rule;
    }
}