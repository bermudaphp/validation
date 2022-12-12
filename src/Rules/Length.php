<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
abstract class Length implements RuleInterface
{
    use RuleTrait;
    protected function __construct(string $message, array $wildcards)
    {
        $this->messages[] = $message;
        $this->wildcards = $wildcards;
    }
    
    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function equalTo(int $length, string $message = 'The string length must be equal to :length'): self
    {
        return new class($message, [':length' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return is_string($var) && mb_strlen($var) == $this->wildcards[':length'];
            }
            
            public function getName(): string 
            {
                return 'length-equal-to';
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function greaterThan(int $length, string $message = 'The string length must be greater than :length'): self
    {
        return new class($message, [':length' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return is_string($var) && mb_strlen($var) > $this->wildcards[':length'];
            }
            
            public function getName(): string 
            {
                return 'length-greater-than';
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function greaterThanEquals(int $length, string $message = 'The string length must be greater than or equals to :length'): self
    {
        return new class($message, [':length' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return is_string($var) && mb_strlen($var) >= $this->wildcards[':length'];
            }
            
            public function getName(): string 
            {
                return 'length-greater-than-equals';
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function lessThan(int $length, string $message = 'The string length must be less than :length'): self
    {
        return new class($message, [':length' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return is_string($var) && mb_strlen($var) < $this->wildcards[':length'];
            }
            
            public function getName(): string 
            {
                return 'length-less-than';
            }
        };
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function lessThanEquals(int $length, string $message = 'The string length must be less than or equals to :length'): self
    {
        return new class($message, [':length' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return is_string($var) && mb_strlen($var) <= $this->wildcards[':length'];
            }
            
            public function getName(): string 
            {
                return 'length-less-than-equals';
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
                return is_string($var) && ($var = mb_strlen($var)) >= $this->wildcards[':min'] && $this->wildcards[':max'] >= $var;
            }
            
            public function getName(): string 
            {
                return 'length-between';
            }
        };
    }
}
