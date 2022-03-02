<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class Numbers implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a array of numbers')
    {
        $this->messages[] = $message;
    }

    protected function doValidate($var): bool
    {
        if (!is_array($var)) {
            return false;
        }
        
        foreach ($var as $item) {
            if (!is_numeric($item)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function getName(): string 
    {
        return 'numbers';
    }
}
