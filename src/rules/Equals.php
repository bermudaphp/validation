<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Validation\Equalible;

final class Equals implements RuleInterface
{
    use RuleTrait;
    public function __construct(private int|float|string $operand, string $message = 'Value must be equal to :operand', private bool $strict = true)
    {
        $this->message = $message;
        $this->wildcards[':operand'] = (string) $this->operand;
    }

    protected function doValidate($var): bool
    {
        return $this->strict ? $var === $this->operand : $var == $this->operand;
    }
}
