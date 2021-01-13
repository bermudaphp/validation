<?php

namespace Bermuda\Validation\Rules;


/**
 * Class Range
 * @package Bermuda\Validation\Rules
 */
class Range implements RuleInterface
{
    use RuleTrait;

    /**
     * @var float
     */
    protected $x, $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if (!is_numeric($value) || !$this->compare($value))
        {
            return [sprintf('The value must be a number in the range from %s to %s', $this->x, $this->y)];
        }

        return [];
    }

    /**
     * @param $value
     * @return bool
     */
    protected function compare($value): bool
    {
        return $this->x > $value && $this->y < $value;
    }

    /**
     * @param \DateTimeInterface $x
     * @param \DateTimeInterface $y
     * @return static
     */
    public static function date(\DateTimeInterface $x, \DateTimeInterface $y): self
    {
        return new class($x, $y) extends Range
        {
            /**
             * @var \DateTimeInterface
             */
            protected $x, $y;

            public function __construct(\DateTimeInterface $x, \DateTimeInterface $y)
            {
                $this->x = $x;
                $this->y = $y;
            }

            /**
             * @param $value
             * @return array
             */
            public function __invoke($value): array
            {
                if ((new Date())->__invoke($value) != []
                    || !$this->compare($value))
                {
                    return [sprintf('The value must be a datetime in the range from %s to %s', $this->x, $this->y)];
                }

                return [];
            }
        };
    }
}
