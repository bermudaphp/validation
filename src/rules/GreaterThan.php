<?php

namespace Bermuda\Validation\Rules;

/**
 * Class GreaterThan
 * @package Bermuda\Validation\Rules
 */
class GreaterThan extends AbstractRule
{
    protected $operand;

    public function __construct($operand)
    {
        if (!is_numeric($operand))
        {
            throw new \InvalidArgumentException('Operand must be a numeric');
        }

        $this->operand = $operand;
    }

    protected function validate($value): bool
    {
        return $value > $this->operand;
    }

    protected function getMessageFor($value): array
    {
        return 'Must be greater than '. $this->operand;
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

        return new class($operand) extends GreaterThan
        {
            use DateTimeFactoryAwareTrait;

            public function __construct(\DateTimeInterface $operand, string $format)
            {
                $this->operand = $operand;
                $this->datetimeFormat = $format
                $this->dateTimeFactory = $this->getDatetimeFactory();
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
                return ['Date must be greater than ' . $this->operand->format($this->datetimeFormat)];
            }
        };
    }

    /**
     * @param $operand
     */
    protected static function check(&$operand): void
    {
        if (!$operand instanceof \DateTimeInterface)
        {
            try
            {
                $operand = new \DateTime($operand);
            }

            catch (\Throwable $e)
            {
                throw new \InvalidArgumentException('Operand must be a \DateTimeInterface instance or datetime string', 0, $e);
            }
        }
    }
}
