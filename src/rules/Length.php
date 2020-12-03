<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Length
 * @package App\Validator\Rules
 */
final class Length implements RuleInterface
{
    use RuleTrait;

    private bool $mb;
    private int $value;

    public function __construct(int $value, bool $mb = true)
    {
        $this->mb = $mb;
        $this->value = $value;
    }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return is_string($value) && ($this->mb ? mb_strlen($value)
            : strlen($value) == $this->value) ? [] :
            ['String length must be equal to ' . $this->value];
    }

}