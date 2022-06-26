<?php

namespace Bermuda\Validation\Rules;

use function Bermuda\String\str_equals;

final class EqualsAny implements RuleInterface
{
    use RuleTrait;
    public function __construct(
        private readonly array $any,
        string $message = 'Must be equal any :any',
        private readonly bool $caseSensitive = false
    ){
        $this->messages[] = $message;
        $this->wildcards[':any'] = implode(',', $this->any);
    }

    protected function doValidate($var): bool
    {
        return str_equals($var, $this->any, $this->caseSensitive);
    }

    public function getName(): string
    {
        return 'equals-any';
    }
}
