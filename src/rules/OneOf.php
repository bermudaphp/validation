<?php

namespace Bermuda\Validation;


use Bermuda\Validation\Rules\RuleTrait;


/**
 * Class OneOf
 * @package Bermuda\Validation
 */
class OneOf implements RuleInterface, \IteratorAggregate
{
    use RuleTrait
    {
        validateNext as protected;
    }

    /**
     * @var RuleInterface[]
     */
    private array $rules = [];

    /**
     * OneOf constructor.
     * @param RuleInterface[] $rules
     */
    public function __construct(iterable $rules = [])
    {
        $this->addRules($rules);
    }

    /**
     * @return RuleInterface[]
     */
    final public function getIterator(): \Generator
    {
        foreach ($this->rules as $rule)
        {
            yield $rule;
        }
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
        $this->rules[get_class($rule)] = $rule;
        return $this;
    }

    /**
     * @param RuleInterface[] $rules
     * @return $this
     */
    final public function addRules(iterable $rules): self
    {
        foreach ($rules as $rule)
        {
            $this->addRule($rule);
        }

        return $this;
    }

    /**
     * @param $value
     * @return array|bool
     */
    public function __invoke($value): array
    {
        $result = [];

        foreach ($this->rules as $rule)
        {
            if (($failure = $rule($value)) == [])
            {
                return $this->validateNext($value);
            }

            $result = array_merge($result, $failure);
        }

        return $result;
    }
    
    /**
     * @param RuleInterface[]|RuleInterface $rule
     * @return static
     */
    public static function make($rule): self
    {
        return new static((array) $rule]);
    }
}
