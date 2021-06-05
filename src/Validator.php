<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;

/**
 * Class Validator
 * @package Bermuda\Validation
 */
class Validator
{
    /**
     * @var RuleInterface[]
     */
    protected array $rules = [];

    public function __construct(iterable $rules = [])
    {
        $this->registerDefaultRules();
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
     * @param RuleInterface $rule
     * @return $this
     */
    final public function add($name, RuleInterface $rule): self
    {
        foreach (is_array($name) ? $name : [$name] as (string) $n)
        {
            $this->rules[$n] = $rule;
        }

        return $this;
    }
    
    /**
     * @param RuleInterface[] $rules
     * @return $this
     */
    public function addRules(iterable $rules): self
    {
        foreach($rules as $n => $rule)
        {
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
     * If validation failed
     * @throws ValidationException 
     */
    final public function validate(array $data): void
    {
        $errors = [];

        foreach ($this->rules as $name => $rule)
        {
            if (($msg = $rule($data[$name] ?? null)) != [])
            {
                $errors[$name] = count($msg) > 1 ? $msg : $msg[0];
            }
        }

        if ($errors != [])
        {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $backtrace['class'] = static::class;

            throw $this->getException($backtrace, $errors);
        }
    }

    /**
     * @param RuleInterface[] $rules
     * @return static
     */
    public static function makeOf(iterable $rules): self
    {
        return new static($rules);
    }
    
    protected function getException(array $backtrace, array $errors): ValidationException
    {
        return new ValidationException($backtrace, $errors);
    }
    
    protected function registerDefaultRules(): void
    {
    }
}
