<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class NotEmpty
 * @package App\Chain\Rules
 */
final class NotEmpty implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return !empty($value) ? [] : ['The value must not be empty!'];
    }
}