<?php

namespace Bermuda\Validation\Rules;


/**
 * Class Length
 * @package Bermuda\Validation\Rules
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
        return is_string($value) && $this->getStringLen($value) == $this->value
            ? $this->validateNext($value) : ['String length must be equal to ' . $this->value];
    }

    /**
     * @param string $len
     * @return int
     */
    private function getStringLen(string $value): int
    {
        return $this->mb ? mb_strlen($value) : strlen($value);
    }
}
