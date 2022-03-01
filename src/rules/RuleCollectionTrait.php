<?php

namespace Bermuda\Validation\Rules;
use Generator;

trait RuleCollectionTrait
{
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
     * @param string $rule
     * @return bool
     */
    public function hasRule(string|RuleInterface $rule): bool
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
     * @param RuleInterface $rule
     * @return $this
     */
    public function addRule(RuleInterface $rule): self
    {
        $this->rules[$rule->getName()] = $rule;
        return $this;
    }

    /**
     * @param RuleInterface[] $rules
     * @return $this
     */
    public function addRules(iterable $rules): self
    {
        foreach ($rules as $rule) $this->addRule($rule);
        return $this;
    }
}
