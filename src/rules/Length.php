<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Length
 * @package App\Validator\Rules
 */
final class Length implements RuleInterface
{
    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        return is_string($value) && mb_strlen($value) == $this->length ? []
            : ['String length must be equal to ' . $this->length];
    }

}