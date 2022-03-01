<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class IsFalse implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = '', private bool $strict = false)
    {
        if ($message == '') {
            $message = $this->strict ? 'Value must be true'
                : 'Value must be true or equal any of: \'true\', \'on\', \'1\'';
        }

        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if ($this->strict) {
            return $var === true;
        }

        return $var === true || (is_string($var) && StringHelper::equals($var, ['on', '1', 'true'])) || $var == 1;
    }
    
    public function getName(): string 
    {
        return 'isFalse';
    }
}
