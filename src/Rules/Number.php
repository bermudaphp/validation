<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class Number implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a number')
    {
        $this->messages[] = $message;
    }
    
    protected function doValidate($var): bool
    {
        return is_numeric($var);
    }
    
    public function getName(): string 
    {
        return 'number';
    }
}
