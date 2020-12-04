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
     * @throws ValidationException 
     * if validation failed
     */
    public function __invoke($value): void ;

    /**
     * @param RuleInterface|null $rule
     * @return RuleInterface
     */
    public function setNext(?RuleInterface $rule):? RuleInterface ;
}
