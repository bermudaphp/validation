<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class Email implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be valid email')
    {
        $this->messages[] = $message;
    }

    protected function doValidate($var): bool
    {
        return is_string($var) && filter_var($var, FILTER_VALIDATE_EMAIL);
    }
    
    public function getName(): string 
    {
        return 'email';
    }
}
