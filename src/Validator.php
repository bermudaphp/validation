<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;
use Bermuda\Validation\Rules\RuleCollectionInterface;
use Bermuda\Validation\Rules\ValidationDataAwareInterface;

class Validator
{
    protected array $rules = [];

    /**
     * @param iterable<RuleInterface> $rules
     */
    public function __construct(iterable $rules = [])
    {
        $this->addRules($this->getDefaultRules());
        
        if ($rules != []) {
            $this->addRules($rules);
        }
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
     * @param RuleInterface
     * @return $this
     */
    final public function add(string|array $name, RuleInterface $rule): self
    {
        foreach (is_array($name) ? $name : [$name] as $n) {
            $this->rules[$n] = $rule;
        }

        return $this;
    }
    
    /**
     * @param iterable<RuleInterface> $rules
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
     * @return array
     */
    final public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $data
     * @throws ValidationException 
     * If validation failed
     */
    final public function validate(array $data): void
    {
        $errors = [];
        foreach ($this->rules as $name => $rule) {
            if ($rule instanceof ValidationDataAwareInterface) {
                $rule->setData($data);
            }

            if (($result = $rule->validate($data[$name])) !== true) {
                $errors[$name] = $result;
            }
        }

        if ($errors != []) {
            throw $this->createException($errors, $data);
        }
    }

    protected function createException(array $errors, array $data, $deep = 3): ValidationException
    {
        return new ValidationException($errors, $data, $this, $deep);
    }

    protected function getDefaultRules(): array
    {
        return [];
    }
}
