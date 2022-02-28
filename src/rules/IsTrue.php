<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class IsTrue implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = '', private bool $strict = false)
    {
        if ($message == '') {
            $message = $this->strict ? 'Value must be boolean'
                : 'Value must be boolean or equal any of: on, true, 1';
        }

        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if ($this->strict) {
            return $var === true;
        }

        return $var == true || (is_string($var) && StringHelper::equals((string) $var, ['on', '1', 'true'])) || $var = 1;
    }
}
