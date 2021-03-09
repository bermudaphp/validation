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
        parent::__construct(null);
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
    protected function getDefaultMessage(): string
    {
        if ($this->x instanceof \DateTimeInterface)
        {
            return "Must be a date in the range from :left to :right";
        }

        return "Must be a number in the range from :left to :right";
    }
    
    /**
     * @return array
     */
    protected function getReplacmentAttributes(): array
    {
        return [
            ':left' => $this->x instanceof \DateTimeInterface ? $this->x->format($this->dateTimeFormat) : $this->x,
            ':right' => $this->y instanceof \DateTimeInterface ? $this->y->format($this->dateTimeFormat) : $this->y
        ];
    }
}
