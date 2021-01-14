<?php

namespace Bermuda\Validation\Rules;

/**
 * Class LessThanEquals
 * @package Bermuda\Validation\Rules
 */
class LessThanEquals extends LessThan
{
    protected function validate($value): bool
    {
        return $value <= $this->operand;
    }

    protected function getMessageFor($value): array
    {
        return 'Must be less than or equals '. $this->operand;
    }

    /**
     * @param string|\DateTimeInterface $operand
     * @param string $format
     * @return DateTimeFactoryAwareTrait|self
     * @throws \InvalidArgumentException
     */
    public static function date($operand = 'now', string $format = 'd/m/Y'): self
    {
        static::check($operand);
        return new class($operand) extends LessThanEquals
        {
            use DateTimeFactoryAwareTrait;

            public function __construct(\DateTimeInterface $operand, string $format)
            {
                $this->operand = $operand;
                $this->datetimeFormat = $format;
                $this->getDatetimeFactory();
            }

            protected function validate($value): bool
            {
                if ($value instanceof \DateTimeInterface)
                {
                    $value = ($this->dateTimeFactory)($value, $this->datetimeFormat);
                }

                return parent::validate($value);
            }

            protected function getMessageFor($value): array
            {
                return ['Date must be less than or equals ' . $this->operand->format($this->datetimeFormat)];
            }
        };
    }
}
