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
     * @return array
     */
    public function __invoke($value): array;

    /**
     * @param RuleInterface|null $rule
     * @return RuleInterface
     */
    public function setNext(?RuleInterface $rule):? RuleInterface ;
}
