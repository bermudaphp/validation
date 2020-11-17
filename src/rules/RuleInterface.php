<?php


namespace Bermuda\Validation\Rules;


/**
 * Interface RuleInterface
 * @package Bermuda\Validation\Rules
 */
interface RuleInterface
{
    /**
     * @return string
     */
    public function getName(): string ;

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array;
}
