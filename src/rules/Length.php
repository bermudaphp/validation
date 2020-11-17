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
        return mb_strlen($value);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'length';
    }
}