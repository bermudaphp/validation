<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Clock\Clock;

final class Date implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a valid date', private ?string $format = null)
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        try {
            return $var instanceof \DateTimeInterface || Clock::create($var, format: $this->format) instanceof \DateTimeInterface;
        } catch (\Throwable) {
            return false;
        }
    }
}
