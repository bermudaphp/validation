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

    /**
     * @param string $message
     * @return RuleInterface
     */
    public static function reverse(string $message = 'Must be empty'): RuleInterface
    {
        return new class($message) implements RuleInterface
        {
            use RuleTrait;
            public function __construct(string $message)
            {
                $this->messages[] = $message;
            }
            protected function doValidate($var): bool
            {
                return empty($var);
            }
            
            public function getName(): string 
            {
                return 'empty';
            }
        };
    }
}
