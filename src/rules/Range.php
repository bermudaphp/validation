<?php

namespace Bermuda\Validation\Rules;

/**
 * Class Range
 * @package Bermuda\Validation\Rules
 */
final class Range extends AbstractRule
{
    private $x, $y;
    private string $dateTimeFormat;

    public function __construct($x, $y, string $dateTimeFormat = 'd/m/Y')
    {
        $this->x = $x; $this->y = $y;
        $this->dateTimeFormat = $dateTimeFormat;
    }

    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return $value >= $this->x && $value <= $this->y;
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        if ($value instanceof \DateTimeInterface)
        {
            return "Must be a date in the range from {$this->x->format($this->datetimeFormat)} to {$this->y->format($this->datetimeFormat)}";
        }

        return "Must be a number in the range from {$this->x} to {$this->y}";
    }
}
