<?php


namespace Bermuda\Validation\Rules;


use function Bermuda\str_equals;
use Bermuda\Validation\RuleInterface;


/**
 * Class Equals
 * @package Bermuda\Validation\Rules
 */
class Equals implements RuleInterface
{
    private string $operand;
    private bool $caseInsensitive;

    public function __construct(string $operand, $caseInsensitive = false)
    {
        $this->operand = $operand;
        $this->caseInsensitive = $caseInsensitive;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'equals';
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if (is_numeric($value))
        {
            $value = (string) $value;
        }

        if (!is_string($value) || !str_equals($value, $this->operand, $this->caseInsensitive))
        {
            return ['The value must be a number or string and equal to ' . $this->operand];
        }

        return [];
    }
}
