<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class NotEmpty
 * @package App\Chain\Rules
 */
final class NotEmpty implements RuleInterface
{
    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        return !empty($value) ? [] : ['The value must not be empty!'];
    }
}