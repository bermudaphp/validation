<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Stdlib\StrHelper;

/**
 * @method string|bool validate 
 */
final class IsTrue implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = '', private bool $strict = false)
    {
        if ($message == '') {
            $message = $this->strict ? 'Value must be true'
                : 'Value must be true or equal any of: \'true\', \'on\', \'yes\', \'y\', \'1\'';
        }

        $this->messages[] = $message;
    }

    protected function doValidate($var): bool
    {
        if ($this->strict) {
            return $var === true;
        }

        return $var === true || (is_string($var) && StrHelper::equals($var, ['on', '1', 'true', 'yes', 'y'])) || $var == 1;
    }
    
    public function getName(): string 
    {
        return 'isTrue';
    }
}
