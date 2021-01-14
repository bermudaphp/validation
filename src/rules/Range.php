<?php

namespace Bermuda\Validation\Rules;


/**
 * Class Range
 * @package Bermuda\Validation\Rules
 */
class Range extends AbstractRule
{
    use RuleTrait;

    protected $x, $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate($value): bool
    {
        return is_numeric($value) && $value >= $this->x && $value <= $this->y;
    }
    
    protected function getMessageFor($value): array
    {
        return ["Must be a number in the range from {$this->x} to {$this->y}"];
    }

    /**
     * @param string|\DateTimeInterface $x
     * @param string|\DateTimeInterface $y
     * @return DateTimeFactoryAwareTrait|self
     * @throws \InvalidArgumentException
     */
    public static function date($x, $y): self
    {
        self::check('x', $x);
        self::check('y', $y);
        
        return new class($x, $y) extends Range
        {
            use DateTimeFactoryAwareTrait;
            
            /**
             * @var \DateTimeInterface
             */
            protected $x, $y;

            public function __construct(\DateTimeInterface $x, \DateTimeInterface $y)
            {
                $this->x = $x;
                $this->y = $y;
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
                return ["Must be a date in the range from {$this->x->format($this->datetimeFormat)} to {$this->y->format($this->datetimeFormat)}"];
            }
        };
    }
    
    private static function check(string $name, &$argument): void
    {
        if (!$argument instanceof \DateTimeInterface)
        {
            try
            {
                $$argument = new \DateTime($argument);
            }

            catch (\Throwable $e)
            {
                throw new \InvalidArgumentException("{$name} must be a \DateTimeInterface instance or datetime string", 0, $e);
            }
        }
    }
}
