<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

/**
 * @method string|bool validate 
 */
final class IsBoolean implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = '', private bool $strict = false)
    {
        if ($message == '') {
            $message = $this->strict ? 'Value must be boolean'
                : 'Value must be boolean or equal any of: \'on\', \'off\', \'true\', \'false\', \'yes\', \'y\', \'n\', \'no\', 0, 1';
        }

        $this->messages[] = $message;
    }

    protected function doValidate($var): bool
    {
        if ($this->strict) {
            return is_bool($var);
        }

        return is_bool($var) || (is_string($var) && StringHelper::isBool($var)
            || ($var == 1 || $var == 0));
    }
    
    public function getName(): string 
    {
        return 'isBoolean';
    }
}
