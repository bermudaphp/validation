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
    
    protected function prepareVar($var): string
    {
        return mb_strlen($var);
    }
    
    public function getName(): string 
    {
        return 'length';
    }

    /**
     * @param int $length
     * @param string $message
     * @return static
     */
    public static function equalTo(int $length, string $message = 'The string length must be equal to :len'): self
    {
        return new class($message, [':len' => $length]) extends Length {
            protected function doValidate($var): bool
            {
                return is_string($var) && $this->prepareVar($var) == $this->wildcards[':len'];
            }
            
            public function getName(): string 
            {
                return 'length.equalTo';
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
                return is_string($var) && $this->prepareVar($var) > $this->wildcards[':len'];
            }
            
            public function getName(): string 
            {
                return 'length.greaterThan';
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
                return is_string($var) && $this->prepareVar($var) >= $this->wildcards[':len'];
            }
            
            public function getName(): string 
            {
                return 'length.greaterThanEquals';
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
                return is_string($var) && $this->prepareVar($var) < $this->wildcards[':len'];
            }
            
            public function getName(): string 
            {
                return 'length.lessThan';
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
                return is_string($var) && $this->prepareVar($var) <= $this->wildcards[':len'];
            }
            
            public function getName(): string 
            {
                return 'length.lessThanEquals';
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
                return is_string($var) && ($var = $this->prepareVar($var)) >= $this->wildcards[':min'] && $this->wildcards[':max'] >= $var;
            }
            
            public function getName(): string 
            {
                return 'length.between';
            }
        };
    }
}
