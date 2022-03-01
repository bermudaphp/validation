<?php

namespace Bermuda\Validation\Rules;

final class LessThan implements RuleInterface
{
    use RuleTrait;
    public function __construct(float|int $operand, string $message = 'Value must be less than :operand')
    {
        $this->message = $message;
        $this->wildcards[':operand'] = $operand;
    }

    protected function doValidate($var): bool
    {
        if (!is_numeric($var)) {
            return false;
        }

        return $this->wildcards[':operand'] > $var;
    }
}
