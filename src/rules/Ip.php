<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class Ip implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Must be valid ip-address')
    {
        $this->messages[] = $message;
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
