<?php


namespace App\Validator;


/**
 * Interface RuleInterface
 * @package App\Chain
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