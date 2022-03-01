<?php

namespace Bermuda\Validation\Rules;
use Generator;

trait RuleCollectionTrait
{
    /**
     * @var array<RuleInterface|RuleCollectionInterface>
     */
    protected array $rules = [];

    /**
     * @param iterable<RuleInterface|RuleCollectionInterface> $rules
     * @throws \InvalidArgumentException if $rules is empty
     */
    public function __construct(iterable $rules = [])
    {
        if ($rules === []) {
            throw new \InvalidArgumentException('Rule array must not be empty');
        }

        $this->addRules($rules);
    }

    /**
     * @return iterable<RuleInterface|RuleCollectionInterface>
     */
    final public function getIterator(): Generator
    {
        foreach ($this->rules as $rule) yield $rule;
    }

    /**
     * @return array<RuleInterface|RuleCollectionInterface>
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @inerhitDoc
     */
    public function hasRule(string|RuleInterface|RuleCollectionInterface $rule): bool
    {
        if (is_string($rule)) {
            return isset($this->rules[$rule]);
        }

        foreach($this->rules as $r) {
            if ($rule === $r) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param RuleInterface|RuleCollectionInterface $rule
     * @return $this
     */
    public function addRule(RuleInterface|RuleCollectionInterface $rule): self
    {
        $this->rules[$rule->getName()] = $rule;
        return $this;
    }

    /**
     * @param iterable<RuleInterface|RuleCollectionInterface> $rules
     * @return $this
     */
    public function addRules(iterable $rules): self
    {
        foreach ($rules as $rule) $this->addRule($rule);
        return $this;
    }
}
