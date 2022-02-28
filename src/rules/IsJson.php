<?php

namespace Bermuda\Validation\Rules;

final class IsJson implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Must be valid JSON string')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            return false;
        }

        try {
            json_decode($var, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return false;
        }
        
        return true;
    }
}
