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
        $this->callback = fn($var, array $data, callable $setErrors): bool => $rule($var, $data, $setErrors);
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
        return ($this->callback)($var, $this->data, function (string|array $errors): void {
            $this->errors = is_string($errors) ? [$errors] : $errors;
        });
    }
}
