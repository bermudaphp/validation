<?php

namespace Bermuda\Validation\Rules;

/**
 * Class LessThan
 * @package Bermuda\Validation\Rules
 */
class LessThanEquals extends AbstractRule
{
    /**
     * @var float|int|string|\DateTimeInterface
     */
    protected $operand;
    protected string $dateTimeFormat;

    protected function __construct($operand, string $dateTimeFormat = 'd/m/Y')
    {
        $this->operand = $operand;
        $this->dateTimeFormat = $dateTimeFormat;
    }
    
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return $value > $this->operand
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        if ($this->operand instanceof \DateTimeInterface)
        {
            return 'Must be a date and less than or equals ' $this->operand->format($this->dateTimeFormat);
        }
        
        return 'Must be less than or equals ' . $this->operand;
    }
}
