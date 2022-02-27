<?php

namespace Bermuda\Validation\Rules;

use Generator;

class OneOf implements RuleInterface, \IteratorAggregate
{
    use RuleTrait;
    /**
     * @var RuleInterface[]
     */
    protected array $rules = [];
    public function __construct(array $rules = [])
    {
        if ($rules === []) {
            throw new \InvalidArgumentException('Rule array must not be empty');
        }

        $this->addRules($rules);
    }

    protected function doValidate($var): bool
    {
        return true;
    }

    /**
     * @return RuleInterface[]
     */
    final public function getIterator(): Generator
    {
        foreach ($this->rules as $rule) yield $rule;
    }

    /**
     * @return RuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param string $name
     * @return bool
     */
    final public function ruleExists(string $name): bool
    {
        return isset($this->rules[$name]);
    }

    /**
     * @param RuleInterface $rule
     * @return $this
     */
    final public function addRule(RuleInterface $rule): self
    {
        $this->rules[$rule::class] = $rule;
        return $this;
    }

    /**
     * @param RuleInterface[] $rules
     * @return $this
     */
    final public function addRules(iterable $rules): self
    {
        foreach ($rules as $rule) $this->addRule($rule);
        return $this;
    }

    /**
     * @inerhitDoc
     */
    public function validate($value): bool|string
    {
        foreach ($this->rules as $rule) {
            if (($result = $rule->validate($value)) === true) {
                return $this->validateNext($var);
            }
        }

        return $result;
    }
}
