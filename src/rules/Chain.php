<?php

namespace Bermuda\Validation\Rules;

/**
 * Class Chain
 * @package  Bermuda\Validation\Rules;
 */
final class Chain
{
    public function __construct()
    {
        throw new \RuntimeException(self::class . ' is not instantiable');
    }
    
    /**
     * @param RuleInterface $rule
     * @param RuleInterface ...$rules
     * @return RuleInterface
     */
    public static function of(RuleInterface $rule, RuleInterface ... $rules): RuleInterface
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
