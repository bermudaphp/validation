<?php

namespace Bermuda\Validation\Rules;


use Bermuda\String\Str;


/**
 * Class RegExp
 * @package Bermuda\Validation\Rules
 */
class RegExp implements RuleInterface
{
    private string $exp;

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
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if (Str::match($this->exp, (string) $value))
        {
            return $this->validateNext($value);
        }

        return [sprintf('The value must match the regular expression: %s', $this->exp)];
    }
}
