<?php

namespace Bermuda\Validation\Rules;

abstract class Length implements RuleInterface
{
    use RuleTrait;
    protected function __construct(string $message, array $wildcards)
    {
        $this->message = $message;
        $this->wildcards = $wildcards;
    }

   protected function prepareVar($var): string
    {
        return mb_strlen($var);
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function equals(int $length, string $message = 'The string length must be equal to :len'): self
    {
        return new class($message, [':len' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return $var == $this->wildcards[':len'];
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function greaterThan(int $length, string $message = 'The string length must be greater than :len'): self
    {
        return new class($message, [':len' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return $var > $this->wildcards[':len'];
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function greaterThanEquals(int $length, string $message = 'The string length must be greater than or equals to :len'): self
    {
        return new class($message, [':len' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return $var >= $this->wildcards[':len'];
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function lessThan(int $length, string $message = 'The string length must be less than :len'): self
    {
        return new class($message, [':len' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return $var < $this->wildcards[':len'];
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function lessThanEquals(int $length, string $message = 'The string length must be less than or equals to :len'): self
    {
        return new class($message, [':len' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return $var <= $this->wildcards[':len'];
            }
        };
    }

    /**
     * @param int $min
     * @param int $max
     * @param string $message
     * @return static
     */
    public static function between(int $min, int $max, string $message = 'The string length must be between :min and :max'): self
    {
        return new class($message, [':min' => $min, ':max' => $max]) extends Length {
            protected function doValidate($var): bool
            {
                return $var >= $this->wildcards[':min'] && $this->wildcards[':max'] >= $var;
            }
        };
    }
}
