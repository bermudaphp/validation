<?php

namespace Bermuda\Validation\Rules;

final class Email implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Must be valid email')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            return false;
        }

        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }
}
