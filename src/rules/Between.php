<?php

namespace Bermuda\Validation\Rules;

final class Between implements RuleInterface
{
    use RuleTrait;
    public function __construct(int|float $min, int|float $max, string $message = 'Value must be between :min and :max')
    {
        $this->message = $message;
        $this->wildcards[':min'] = $min;
        $this->wildcards[':max'] = $max;
    }

    protected function doValidate($var): bool
    {
        return is_numeric($var) && $var >= $this->wildcards[':min'] && $this->wildcards[':max'] >= $var;
    }
}
