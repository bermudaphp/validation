<?php

namespace Bermuda\Validation\Rules;

/**
 * Class StrLength
 * @package Bermuda\Validation\Rules
 */
final class StrLength extends AbstractRule
{
    private string $msg;
    private bool $multibyte;

    private function __construct(string $msg, bool $multibyte = true)
    {
        $this->msg = $msg;
        $this->multibyte = $multibyte;
       
    }

    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        $value = $this->getStringLength($value);
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return $this->msg;
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function equals(int $length, bool $multibyte = true): self
    {
        return (new self('String length must be equals to ' . $length, $multibyte))->setNext(new Equals($length));
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function greaterThan(int $length, bool $multibyte = true): self
    {
        return (new self('String length must be greater than ' . $length, $multibyte))->setNext(new GreaterThan($length));
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function greaterThanEquals(int $length, bool $multibyte = true): self
    {
       return (new self('String length must be greater than or equals ' . $length, $multibyte))->setNext(new GreaterThanEquals($length));
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function lessThan(int $length, bool $multibyte = true): self
    {
        return (new self('String length must be less than ' . $length, $multibyte))->setNext(new LessThan($length));
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function lessThanEquals(int $length, bool $multibyte = true): self
    {
        return (new self('String length must be less than or equals ' . $length, $multibyte))->setNext(new LessThanEquals($length));
    }

    /**
     * @param int $length
     * @param bool $multibite
     * @return static
     */
    public static function range(int $minLength, int $maxLength, bool $multibyte = true): self
    {
        return (new self("String length must be in the range from {$minLength} to {$maxLength}", $multibyte))->setNext(new Range($minLength, $maxLength));
    }

    /**
     * @param string $value
     * @return int
     */
    private function getStringLength(string $value): int
    {
        return $this->mb ? mb_strlen($value) : strlen($value);
    }
}
