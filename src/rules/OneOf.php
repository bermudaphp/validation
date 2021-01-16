<?php

namespace Bermuda\Validation\Rules;

/**
 * Class OneOf
 * @package Bermuda\Validation\Rules
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
    protected array $rules = [];

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
     * @return array
     */
    public function __invoke($value): array
    {
        foreach ($this->rules as $rule)
        {
            if (($msg = $rule($value)) == [])
            {
                return $this->validateNext($value);
            } 
        }

        return $msg;
    }
    
    /**
     * @param RuleInterface[]|RuleInterface $rule
     * @return static
     */
    public static function make($rule): self
    {
        return new static(is_iterable($rule) ? $rule : [$rule]);
    }
    
    /**
     * @param RuleInterface[]|RuleInterface $rule
     * @return static
     */
    final public function require($rule): self
    {
        return static::make((new Required)->setNext($rule));
    }
    
    /**
     * @param RuleInterface[]|RuleInterface $rule
     * @return static
     */
    final public function allowEmpty($rule): self
    {
        return static::make(new AllowEmpty($rule));
    }
}
