<?php

namespace Bermuda\Validation\Rules;

use function Bermuda\Stdlib\StrHelper;

final class EqualsAny implements RuleInterface
{
    use RuleTrait;
    public function __construct(
        private readonly array $any,
        string $message = 'Must be equal any :any',
        private readonly bool $ignoreCase = false
    ){
        $this->messages[] = $message;
        $this->wildcards[':any'] = implode(',', $this->any);
    }

    protected function doValidate($var): bool
    {
        return StrHelper::equals($var, $this->any, $this->ignoreCase);
    }

    public function getName(): string
    {
        return 'equals-any';
    }
}
