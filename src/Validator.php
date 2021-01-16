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
    private array $rules = [];

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
     * @param bool $require
     * @return $this
     */
    final public function add($name, RuleInterface $rule): self
    {
        foreach ((array) $name as $n)
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

        foreach ($this->rules as $n => $rule)
        {
            if (($msg = $rule($data[$n] ?? null)) != [])
            {
                $errors[$n] = count($msg) > 1 ? $msg : $msg[0];
            }
        }

        if ($errors != [])
        {
            $prev = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $prev['class'] = static::class;

            throw new ValidationException($prev, $errors);
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
    
    protected function registerDefaultRules(): void
    {
    }
}
