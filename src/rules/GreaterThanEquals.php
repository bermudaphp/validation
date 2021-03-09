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
        parent::__construct(null);
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
    protected function getDefaultMessage($value): string
    {
        if ($this->operand instanceof \DateTimeInterface)
        {
            return 'Must be a date and greater than or equals :operand';
        }
        
        return 'Must be greater than or equals :operand';
    }
    
    /**
     * @return array
     */
    protected function getReplacmentAttributes(): array
    {
        return [':operand' => $this->operand instanceof \DateTimeInterface ? $this->operand->format($this->dateTimeFormat) : $this->operand];
    }
}
