<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class Boolean implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be boolean or string equal any of: on, off, true, false, 0, 1')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        return is_bool($var) || (is_string($var) && StringHelper::equals((string) $var, ['on', 'off', '1', '0', 'true', 'false']));
    }
}
