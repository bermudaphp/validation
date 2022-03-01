<?php

namespace Bermuda\Validation\Rules;

final class Number implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a number')
    {
        $this->message = $message;
    }
    
    protected function doValidate($var): bool
    {
        return is_numeric($var);
    }
}
