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
    public function validate($value): array ;
}
