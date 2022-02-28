<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Clock\Clock;

final class Date implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a valid date')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        try {
            return $var instanceof \DateTimeInterface || Clock::create($var) instanceof \DateTimeInterface;
        } catch (\Throwable) {
            return false;
        }
    }
}
