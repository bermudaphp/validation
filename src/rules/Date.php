<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Datetime
 * @package App\Validator\Rules
 */
class Date implements RuleInterface
{
    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if ($value instanceof \DateTimeInterface)
        {
            return [];
        }

        try
        {
            new \DateTime($value);
        }

        catch (\Throwable $e)
        {
            return ['The value must be a DateTime string'];
        }

        return [];
    }
}