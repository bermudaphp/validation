<?php

namespace Bermuda\Validation;


use Bermuda\Validation\Rules\RuleInterface;


/**
 * Class Validator
 * @package Bermuda\Validation
 */
class Validator
{
    private array $rules = [];

    public function __construct(array $rules = [])
    {
        $this->registerDefaultRules();
        
        foreach ($rules as $name => $datum)
        {
            $this->add($name, $datum[0], $datum[1] ?? false);
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
            if (($messages = $rule($data[$name] ?? null)) != [])
            {
                $errors[$name] = $messages;
            }
        }

        if ($errors != [])
        {
            $previous = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
            $previous['class'] = static::class;

            throw new ValidationException($previous, $errors);
        }
    }

    /**
     * @param array $rules
     * @return static
     */
    public static function make(array $rules): self
    {
        return new static($rules);
    }
    
    protected function registerDefaultRules(): void
    {
    }
}
