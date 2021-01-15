<?php

namespace Bermuda\Validation\Rules;

/**
 * Class GreaterThanEquals
 * @package Bermuda\Validation\Rules
 */
class GreaterThanEquals extends AbstractRule
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
        return $value >= $this->operand;
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        if ($this->operand instanceof \DateTimeInterface)
        {
            return 'Must be a date and greater than or equals ' . $this->operand->format($this->dateTimeFormat);
        }
        
        return 'Must be greater than or equals ' . $this->operand;
    }
}
