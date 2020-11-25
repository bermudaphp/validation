<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Numeric
 * @package App\Chain\Rules
 */
class IsNumber implements RuleInterface
{
    private bool $isArray;

    public function __construct(bool $isArray = false)
    {
        $this->isArray = $isArray;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'isNumber';
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if ($this->isArray)
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