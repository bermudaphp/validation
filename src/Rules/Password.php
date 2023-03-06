<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Stdlib\StrHelper;

final class Password implements RuleInterface, ValidationDataAwareInterface
{
    use RuleTrait;
    private ?array $data = null;
    private ?string $confirm = null;
    private bool $symbols = true, $numbers = true;
    public function __construct(private int $length = 8, array $messages = [])
    {
        if ($messages == []) {
            $messages['stringable'] = 'Must be a password string';
            $messages['confirm'] = 'Passwords do not match';
            $messages['symbols'] = 'Password must contain at least one symbol';
            $messages['numbers'] = 'Password must contain at least one number';
            $messages['length'] = 'Minimum password length - :length characters';
        }
        
        $this->messages = $messages;
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
        if (!StrHelper::isStringable($var)) {
            $this->errors[] = $this->messages['stringable'];
            return false;
        }
        
        $var = (string) $var;
        if ($this->symbols && !StrHelper::containsSymbols($var)) {
            $this->errors[] = $this->messages['symbols'];
        }

        if ($this->numbers && !StrHelper::containsNumbers($var)) {
            $this->errors[] = $this->messages['numbers'];
        }

        if ($this->length > mb_strlen($var)) {
            $this->errors[] = $this->messages['length'];
        }
        
        if ($this->confirm != null && ($this->data[$this->confirm] ?? null) != $var) {
            $this->errors[] = $this->messages['confirm'];
            $this->wildcards[':confirm'] = $this->confirm;
        }

        return $this->errors == [];
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
