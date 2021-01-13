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
     * @return $this
     */
    final public function require($name, RuleInterface $rule): self
    {
        return $this->add($name, $rule, true);
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface $rule
     * @return $this
     */
    final public function optional($name, RuleInterface $rule): self
    {
        return $this->add($name, $rule, false);
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface $rule
     * @param bool $require
     * @return $this
     */
    final public function add($name, RuleInterface $rule, bool $require = false): self
    {
        foreach ((array) $name as $item)
        {
            $this->rules[$item] = compact('rule', 'require');
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

        foreach ($this->rules as $name => $item)
        {
            if (!array_key_exists($name, $data))
            {
                if ($item['require'])
                {
                    $errors[$name] = ['Item with key ' . $name . ' is required!'];
                }

                continue;
            }

            if (($failure = $item['rule']($data[$name])) != [])
            {
                $errors[$name] = $failure;
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
