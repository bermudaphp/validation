<?php

namespace Bermuda\Validation\Rules;

final class Ip implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Must be valid ip-address')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            return false;
        }

        return filter_var($var, FILTER_VALIDATE_IP);
    }
    
    public function getName(): string 
    {
        return 'ip';
    }
}
