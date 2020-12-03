<?php

namespace Bermuda\Validation\Rules;


/**
 * Class Number
 * @package Bermuda\Validation\Rules
 */
class Number implements RuleInterface
{
    use RuleTrait;

    private bool $arrayOfNumbers;

    public function __construct(bool $arrayOfNumbers = false)
    {
        $this->arrayOfNumbers = $arrayOfNumbers;
    }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if ($this->arrayOfNumbers)
        {
            foreach ((array) $value as $item)
            {
                if (!is_numeric($item))
                {
                    return ['Value must be array of numbers!'];
                }

                return [];
            }
        }

        return is_numeric($value) ? [] : ['The value must be a number!'];
    }
}
