<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class NotEmpty implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Must be not empty')
    {
        $this->messages[] = 'Must be not empty';
    }

    protected function doValidate($var): bool
    {
        return !empty($var);
    }
    
    public function getName(): string 
    {
        return 'notEmpty';
    }
}
