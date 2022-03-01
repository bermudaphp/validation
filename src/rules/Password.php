<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class Password implements RuleInterface, ValidationDataAwareInterface
{
    use RuleTrait;
    private ?array $data = null;
    private ?string $confirm = null;
    private bool $symbols = true, $numbers = true;
    public function __construct(private int $length = 8, private array $messages = [])
    {
        if ($this->messages == []) {
            $this->messages['not'] = 'Value must be password string';
            $this->messages['confirm'] = 'Passwords do not match';
            $this->messages['symbols'] = 'Password must contain at least one symbol';
            $this->messages['numbers'] = 'Password must contain at least one number';
            $this->messages['length'] = 'Minimum password length - :length characters';
        }

        $this->wildcards[':length'] = $this->length;
    }

    /**
     * @param array $data
     * @return self
     */
    public function setData(array $data): ValidationDataAwareInterface
    {
        $this->data = $data;
        return $this;
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

        if ($this->confirm != null && ($data[$this->confirm] ?? null) != $var) {
            $this->message = $this->messages['confirm'];
            $this->wildcards[':confirm'] = $this->confirm;
            return false;
        }

        return true;
    }

    public function getName(): string
    {
        return 'password';
    }

    public function needConfirm (string $key): self
    {
        $this->confirm = $key;
        return $this;
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
