<?php

namespace App\Validation;

use Bermuda\Validation\Rules\RuleInterface;
use Bermuda\Validation\Rules\RuleTrait;
use Bermuda\Validation\Rules\ValidationDataAwareInterface;
use Bermuda\Validation\Rules\ValidationDataTrait;

final class Callback implements RuleInterface, ValidationDataAwareInterface
{
    use RuleTrait, ValidationDataTrait;
    private string $name;
    private \Closure $callback;
    public function __construct(callable $rule, string $message)
    {
        $this->messages[] = $message;
        $this->callback = static fn($var): bool => $rule($var);
    }

    /**
     * @param string $name
     * @return Callback
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }


    public function getName(): string
    {
        return $this->name ?? spl_object_hash($this);
    }

    protected function doValidate($var): bool
    {
        return ($this->callback)($var, $this->data);
    }
}
