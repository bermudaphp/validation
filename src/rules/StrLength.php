<?php

namespace Bermuda\Validation\Rules;


/**
 * Class StrLength
 * @package Bermuda\Validation\Rules
 */
class StrLength extends AbstractRule
{
    protected int $length;
    protected bool $multibyte;

    public function __construct(int $length, bool $multibyte = true)
    {
        $this->length = $length;
        $this->multibyte = $multibyte;
    }

    protected function validate($value): bool
    {
        return is_string($value) && $this->getStringLen($value) == $this->length;
    }

    protected function getMessageFor($value): array
    {
        ['Length must be equal to ' . $this->value];
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function equals(int $length, bool $multibyte = true): self
    {
        return new self($length, $multibyte);
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function greaterThan(int $length, bool $multibyte = true): self
    {
        return new class($length, $multibyte) extends StrLength
        {
            protected function validate($value): bool
            {
                return is_string($value) && $this->getStringLen($value) > $this->length;
            }
        };
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function greaterThanOrEquals(int $length, bool $multibyte = true): self
    {
        return new class($length, $multibyte) extends StrLength
        {
            protected function validate($value): bool
            {
                return is_string($value) && $this->getStringLen($value) >= $this->length;
            }
        };
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function lessThan(int $length, bool $multibyte = true): self
    {
        return new class($length, $multibyte) extends StrLength
        {
            protected function validate($value): bool
            {
                return is_string($value) && $this->getStringLen($value) < $this->length;
            }
        };
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function lessThanOrEquals(int $length, bool $multibyte = true): self
    {
        return new class($length, $multibyte) extends StrLength
        {
            protected function validate($value): bool
            {
                return is_string($value) && $this->getStringLen($value) <= $this->length;
            }
        };
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function range(int $left, int $right, bool $multibyte = true): self
    {
        return new class($left, $right, $multibyte) extends StrLength
        {
            private int $right;

            public function __construct(int $length, int $right, bool $multibyte = true)
            {
                parent::__construct($length, $right, $multibyte);
            }

            protected function validate($value): bool
            {
                return is_string($value) && $this->length
                    <= ($len = $this->getStringLen($value))
                    && $this->right >= $len;
            }
        };
    }

    /**
     * @param string $len
     * @return int
     */
    protected function getStringLen(string $value): int
    {
        return $this->mb ? mb_strlen($value) : strlen($value);
    }
}
