<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\Str;

/**
 * Class RegExp
 * @package Bermuda\Validation\Rules
 */
class RegExp extends AbstractRule
{
    protected string $exp;

    public function __construct(string $exp)
    {
        $this->exp = $exp;
    }

    /**
     * @return string
     */
    public function getExp(): string
    {
        return $this->exp;
    }

    /**
     * @param string $regExp
     * @return $this
     */
    public function withExp(string $regExp): self
    {
        $copy = clone $this;
        $copy->exp = $regExp;
        
        return $copy;
    }

    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return Str::match($this->exp, (string) $value);
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return sprintf('Must be match the regular expression: %s', $this->exp);
    }
}
