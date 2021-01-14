<?php

namespace Bermuda\Validation\Rules;


/**
 * Class Date
 * @package Bermuda\Validation\Rules
 */
final class Date extends AbstractRule
{
    use DateTimeFactoryAwareTrait;
    
    public function __construct(string $format = 'd/m/Y')
    {
        $this->datetimeFormat = $format;
        $this->dateTimeFactory = $this->getDateTimeFactory();
    }
    
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        if (!$value instanceof \DateTimeInterface)
        {
            $value = ($this->dateTimeFactory)($value, $this->datetimeFormat)
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
        return (new self($format))->setNext(new GreaterThenEquals($operand));
    }
    
    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function greaterThen(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new GreaterThen($operand));
    }

    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function lessThen(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new LessThen($operand));
    }
    
    /**
     * @param \DateTimeInterface $operand
     * @param string $format
     * @return self
     */
    public static function lessThenEquals(\DateTimeInterface $operand, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new LessThenEquals($operand));
    }

    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a date';
    }
}
