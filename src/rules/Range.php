<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Range
 * @package App\Chain\Rules
 */
final class Range implements RuleInterface
{
    private float $x, $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'range';
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if (!is_numeric($value) || ($this->x > $value || $this->y < $value))
        {
            return [sprintf('The value must be a number in the range from %s to %s', $this->x, $this->y)];
        }

        return [];
    }
}