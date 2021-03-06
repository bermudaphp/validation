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
     * @param \DateTimeInterface|null $operand
     * @param string $format
     * @return self
     */
    public static function equals(?\DateTimeInterface $operand = null, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new Equals($operand ?? new \DateTime()));
    }
    
    /**
     * @param \DateTimeInterface|null $operand
     * @param string $format
     * @return self
     */
    public static function greaterThenEquals(?\DateTimeInterface $operand = null, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new GreaterThanEquals($operand ?? new \DateTime()));
    }
    
    /**
     * @param \DateTimeInterface|null $operand
     * @param string $format
     * @return self
     */
    public static function greaterThen(?\DateTimeInterface $operand = null, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new GreaterThan($operand ?? new \DateTime()));
    }

    /**
     * @param \DateTimeInterface|null $operand
     * @param string $format
     * @return self
     */
    public static function lessThen(?\DateTimeInterface $operand = null, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new LessThan($operand ?? new \DateTime()));
    }
    
    /**
     * @param \DateTimeInterface|null $operand
     * @param string $format
     * @return self
     */
    public static function lessThenEquals(?\DateTimeInterface $operand = null, string $format = 'd/m/Y'): self
    {
        return (new self($format))->setNext(new LessThanEquals($operand ?? new \DateTime()));
    }

    /**
     * @inheritDoc
     */
    protected function getMessage($value): string
    {
        return 'Must be a date';
    }
}
