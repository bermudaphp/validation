<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;
use Bermuda\Validation\Equalible;
use function Bermuda\String\_string;

final class Password implements RuleInterface
{
    use RuleTrait;
    private bool $symbols = true, $numbers = true;
    public function __construct(private int $length = 8, private array $messages = [])
    {
        if ($this->messages == []) {
            $this->messages['not'] = 'Value must be password string';
            $this->messages['symbols'] = 'Password must contain at least one symbol';
            $this->messages['numbers'] = 'Password must contain at least one number';
            $this->messages['length'] = 'Minimum password length - :length characters';
        }

        $this->wildcards[':length'] = $this->length;
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            $this->message = $this->messages['not'];
            return false;
        }

        if ($this->symbols && !StringHelper::containsSymbols($var)) {
            $this->message = $this->messages['symbols'];
           return false;
        }

        if ($this->numbers && !StringHelper::containsNumbers($var)) {
            $this->message = $this->messages['numbers'];
            return false;
        }

        if ($this->length >= mb_strlen($var)) {
            $this->message = $this->messages['length'];
            return false;
        }

        return true;
    }

    public function getName(): string
    {
        return 'password';
    }

    /**
     * @return bool
     */
    public function symbols(bool $mode): self
    {
        $this->symbols = $mode;
        return $this;
    }

    /**
     * @return bool
     */
    public function numbers(bool $mode): self
    {
        $this->numbers = $mode;
        return $this;
    }
}
