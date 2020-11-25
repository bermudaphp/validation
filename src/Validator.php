<?php


namespace App\Validator;


/**
 * Class Validator
 * @package App\Validator
 */
final class Validator
{
    private array $rules = [];

    public function __construct(array $rules)
    {
        foreach ($rules as $name => $datum)
        {
            $this->add($name, $datum[0], $datum[1] ?? false);
        }
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface $rule
     * @return $this
     */
    public function require($name, RuleInterface $rule): self
    {
        return $this->add($name, $rule, true);
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface $rule
     * @return $this
     */
    public function optional($name, RuleInterface $rule): self
    {
        return $this->add($name, $rule, false);
    }

    /**
     * @param string|string[] $name
     * @param RuleInterface $rule
     * @param bool $require
     * @return $this
     */
    public function add($name, RuleInterface $rule, bool $require = false): self
    {
        foreach ((array) $name as $item)
        {
            $this->rules[$item] = compact('rule', 'require');
        }

        return $this;
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

            if (($failure = $item['rule']->validate($data[$name])) != [])
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
        return new self($rules);
    }
}
