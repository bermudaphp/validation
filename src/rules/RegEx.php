<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

class RegEx implements RuleInterface
{
    use RuleTrait;
    public function __construct(protected string $exp, string $message = 'Value must be match the regular expression: :exp')
    {
        $this->exp = $exp;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getExp(): string
    {
        return $this->exp;
    }

    /**
     * @param string $regEx
     * @return static
     */
    public function withExp(string $regEx): self
    {
        $copy = clone $this;
        $copy->exp = $regEx;
        
        return $copy;
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            return false;
        }
        
        return StringHelper::match($this->exp, $var);
    }
}
