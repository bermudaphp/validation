<?php

namespace App;


use Bermuda\Validation\Rules\AbstractRule;

/**
 * Class GreaterThan
 * @package App
 */
class LessThan extends AbstractRule
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
        return 'Must be less than ';
    }

    /**
     * @param string|\DateTimeInterface $operand
     * @return DateTimeFactoryAwareTrait|self
     * @throws \InvalidArgumentException
     */
    public static function date($operand = 'now'): self
    {
        static::check($operand);

        return new class($operand) extends LessThan
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

            /**
             * @param $value
             * @return string[]
             */
            protected function getMessageFor($value): array
            {
                return ['Date must be less than ' . $this->operand->format($this->datetimeFormat)];
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