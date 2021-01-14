<?php

namespace App;

/**
 * Class LessThanEquals
 * @package App
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
     * @return DateTimeFactoryAwareTrait|self
     * @throws \InvalidArgumentException
     */
    public static function date($operand = 'now'): self
    {
        static::check($operand);
        return new class($operand) extends GreaterThanEquals
        {
            use DateTimeFactoryAwareTrait;

            public function __construct(\DateTimeInterface $operand)
            {
                $this->operand = $operand;
            }

            protected function validate($value): bool
            {
                if ($value instanceof \DateTimeInterface)
                {
                    $value = ($this->dateTimeFactory)($value);
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