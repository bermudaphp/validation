<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;

class Validator
{
    /**
     * @var RuleInterface[]|RuleCollectionInterface[]
     */
    protected array $rules = [];
    public function __construct(iterable $rules = [])
    {
        $rules = array_merge($this->registerDefaultRules(), $rules);
        $this->addRules($rules);
    }

    /**
     * @param array $data
     * @throws ValidationException if validation failed
     */
    final public function __invoke(array $data): void
    {
        $this->validate($data);
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface|RuleCollectionInterface $rule
     * @return $this
     */
    final public function add(string|array $name, RuleInterface|RuleCollectionInterface $rule): self
    {
        foreach (is_array($name) ? $name : [$name] as $n) {
            $this->rules[$n] = $rule;
        }

        return $this;
    }
    
    /**
     * @param RuleInterface[]|RuleCollectionInterface[] $rules
     * @return $this
     */
    public function addRules(iterable $rules): self
    {
        foreach($rules as $n => $rule) {
            $this->add($n, $rule);
        }
        
        return $this;
    }

    /**
     * @return RuleCollectionInterface[]|RuleInterface[]
     */
    final public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $data
     * If validation failed
     * @throws ValidationException 
     */
    final public function validate(array $data): void
    {
        $errors = [];
        foreach ($this->rules as $name => $rule) {
            if (($result = $rule->validate($data[$name])) !== true) {
                $errors[$name] = $result;
            }
        }

        if ($errors != []) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $backtrace['class'] = static::class;
            $this->throwException($backtrace, $errors);
        }
    }
    
    protected function throwException(array $backtrace, array $errors): never
    {
        throw new ValidationException($backtrace, $errors);
    }
    
    protected function getDefaultRules(): array
    {
        return [];
    }
}
