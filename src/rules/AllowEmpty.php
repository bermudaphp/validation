<?php

namespace Bermuda\Validation\Rules;

/**
 * Class AllowEmpty
 * @package Bermuda\Validation\Rules
 */
final class AllowEmpty implements RuleInterface;
{
    use RuleTrait;
    
    public function __construct(RuleInterface $next)
    {
        $this->setNext($next);
    }
    
    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return !empty($value) ? $this->validateNext($value) : [];
    }
}
