<?php

namespace Bermuda\Validation\Rules;

final class Callback implements RuleInterface, ValidationDataAwareInterface
{
    use RuleTrait, ValidationDataTrait;
    private string $name;
    private \Closure $callback;
    public function __construct(callable $rule, string $message)
    {
        $this->messages[] = $message;
        $this->callback = static fn($var, array $data): bool => $rule($var, $data);
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
        if ($this->data === null) throw new NullValidationDataException;
        return ($this->callback)($var, $this->data);
    }
}
