<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\Str;

/**
 * Class Equals
 * @package Bermuda\Validation\Rules
 */
class Equals extends AbstractRule
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
        return $value == $this->operand
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        if ($this->operand instanceof \DateTimeInterface)
        {
            return 'Must be date and equals to' $this->operand->format($this->dateTimeFormat);
        }
        
        return 'Must be equals to ' . $this->operand;
    }
}
