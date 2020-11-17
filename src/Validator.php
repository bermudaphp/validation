<?php


namespace Bermuda\Validation;


use Bermuda\Validation\RuleInterface;


/**
 * Class Validator
 * @package Bermuda\Validation
 */
final class Validator
{
    private array $rules = [];

    /**
     * @param string $name
     * @param RuleInterface $rule
     * @param bool $require
     * @return $this
     */
    public function add(string $name, RuleInterface $rule, bool $require = false): self
    {
        $this->rules[$name] = compact('rule', 'require');
        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    public function validate(array $data): array
    {
        $messages = [];

        foreach ($this->rules as $name => $item)
        {
            if (!array_key_exists($name, $data))
            {
                if ($item['require'])
                {
                    $messages[$name] = ['Missing require key: ' . $name];
                }
                
                continue;
            }

            if (($failure = $item['rule']->validate($data[$name])) != [])
            {
                $messages[$name] = $failure;
            }
        }

        return $messages;
    }

    /**
     * @return static
     */
    public static function make(array $data = []): self
    {
        $v = new self();
    
        foreach ($data as $name => $datum)
        {
            $v->add($name, $datum[0], $datum[1] ?? false);
        }

        return $v;
    }
}
