<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class IsBoolean implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = '', private bool $strict = false)
    {
        if ($message == '') {
            $message = $this->strict ? 'Value must be boolean'
                : 'Value must be boolean or equal any of: \'on\', \'off\', \'true\', \'false\', 0, 1';
        }

        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if ($this->strict) {
            return is_bool($var);
        }

        return is_bool($var) || (is_string($var) && StringHelper::equals($var, ['on', 'off', '1', '0', 'true', 'false']))
            || ($var == 1 || $var == 0);
    }
}
