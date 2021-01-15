<?php

namespace Bermuda\Validation\Rules;

/**
 * Class Date
 * @package Bermuda\Validation\Rules
 */
final class Date extends AbstractRule
{
    use DateTimeFactoryAwareTrait;
    
    public function __construct(string $format = 'd/m/Y', callable $dateTimeFactory = null)
    {
        $this->dateTimeFormat = $format;
        $this->dateTimeFactory = $dateTimeFactory ?? $this->getDateTimeFactory();
    }
    
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        if (!$value instanceof \DateTimeInterface)
        {
            $value = ($this->dateTimeFactory)($value, $this->dateTimeFormat);
        }
        
        return true;
    }
    
    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function equals(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new Equals($operand));
    }
    
    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function greaterThenEquals(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new GreaterThanEquals($operand));
    }
    
    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function greaterThen(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new GreaterThan($operand));
    }

    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function lessThen(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new LessThan($operand));
    }
    
    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function lessThenEquals(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new LessThanEquals($operand));
    }

    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a date';
    }
}
