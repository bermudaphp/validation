<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;
use Bermuda\Validation\Rules\RuleCollectionInterface;
use Bermuda\Validation\Rules\ValidationDataAwareInterface;

class Validator implements ValidatorInterface
{
    protected array $rules = [];

    /**
     * @param iterable<RuleInterface> $rules
     */
    public function __construct(iterable $rules = [])
    {
        $this->addRules($this->getDefaultRules());
        if ($rules != []) $this->addRules($rules);
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    public function __invoke(array $data): void
    {
        $this->validate($data);
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface
     * @return static
     */
    public function add(string|array $name, RuleInterface $rule): static
    {
        foreach (is_array($name) ? $name : [$name] as $n) $this->rules[$n] = $rule;
        return $this;
    }

    /**
     * @param iterable<RuleInterface> $rules
     * @return static
     */
    public function addRules(iterable $rules): static
    {
        foreach($rules as $n => $rule) $this->add($n, $rule);
        return $this;
    }

    /**
     * @return RuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param iterable<RuleInterface> $rules
     * @return $this
     */
    public function withRules(iterable $rules): static
    {
        $copy = clone $this;
        $copy->rules = [];

        return $copy->addRules($rules);
    }

    /**
     * @inheritDoc
     */
    public function validate(array $data): void
    {
        $errors = [];
        foreach ($this->rules as $name => $rule) {
            if ($rule instanceof ValidationDataAwareInterface) $rule->setData($data);
            if (($result = $rule->validate($data[$name] ?? null)) !== true) $errors[$name] = $result;
        }

        if ($errors !== []) {
            $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            throw new ValidationException($errors, $data, $this, $stack['file'], $stack['line']);
        }
    }
    
    /**
     * @return RuleInterface[]
     */
    protected function getDefaultRules(): array
    {
        return [];
    }
}
