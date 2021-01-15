<?php

namespace Bermuda\Validation\Rules;

/**
 * Class GreaterThan
 * @package Bermuda\Validation\Rules
 */
class GreaterThan extends AbstractRule
{
    /**
     * @var float|int|string|\DateTimeInterface
     */
    protected $operand;
    protected string $dateTimeFormat;

    public function __construct($operand, string $dateTimeFormat = 'd/m/Y')
    {
        $this->operand = $operand;
        $this->dateTimeFormat = $dateTimeFormat;
    }
    
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return $value > $this->operand;
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        if ($this->operand instanceof \DateTimeInterface)
        {
            return 'Must be a date and greater than ' . $this->operand->format($this->dateTimeFormat);
        }
        
        return 'Must be greater than ' . $this->operand;
    }
}
