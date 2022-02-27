<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class Boolean implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be boolean')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        return StringHelper::equals($var, ['on', 'off', '1', '0'], true);
    }
}
