<?php

namespace Bermuda\Validation\Rules;

/**
 * Interface RuleInterface
 * @package Bermuda\Validation\Rules
 */
interface RuleInterface
{
    /**
     * @param $value
     * Returns an empty array if the check passes, 
     * otherwise returns an array of error messages
     * @return string[]
     */
    public function __invoke($value): array ;

    /**
     * @param RuleInterface|null $rule
     * @return RuleInterface
     */
    public function setNext(?RuleInterface $rule): RuleInterface ;
}
