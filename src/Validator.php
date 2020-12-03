<?php


namespace Bermuda\Validation;


/**
 * Class Validator
 * @package Bermuda\Validation
 */
class Validator
{
    private array $rules = [];

    public function __construct(array $rules)
    {
        foreach ($rules as $name => $datum)
        {
            $this->add($name, $datum[0], $datum[1] ?? false);
        }
        
        $this->registerRules();
    }

    /**
     * @param array $data
     * @return array
     */
    final public function __invoke(array $data): array
    {
        return $this->validate($data);
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
     * @return array
     */
    public function validate(array $data): array
    {
        $errors = [];

        foreach ($this->rules as $name => $item)
        {
            if (!array_key_exists($name, $data))
            {
                if ($item['require'])
                {
                    $errors[$name] = ['Field with key ' . $name . ' is required!'];
                }

                continue;
            }

            if (($failure = $item['rule']($data[$name])) != [])
            {
                $errors[$name] = $failure;
            }
        }

        return $errors;
    }

    /**
     * @param array $rules
     * @return static
     */
    public static function make(array $rules): self
    {
        return new static($rules);
    }
    
    protected function registerRules(): void
    {
    }
}
