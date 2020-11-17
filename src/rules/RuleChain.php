<?php


namespace Bermuda\Validation\Rules;


/**
 * Class RuleChain
 * @package Bermuda\Validation\Rules
 */
final class RuleChain implements RuleInterface
{
    private bool $break;

    /**
     * @var RuleInterface[]
     */
    private array $rules = [];

    /**
     * RuleChain constructor.
     * @param RuleInterface[] $rules
     * @param bool $break
     */
    public function __construct(iterable $rules, bool $break = false)
    {
        $this->addRules($rules)->break = $break;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $str = '';
        $glue = '';

        foreach ($this->rules as $rule)
        {
            $str .= $glue . $rule->getName();
            $glue = ';';
        }

        return $str;
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        $messages = [];

        foreach ($this->rules as $rule)
        {
            if (($failure = $rule->validate($value)) != [])
            {
                $messages = array_merge($messages, $failure);

                if ($this->break)
                {
                    break;
                }
            }
        }

        return $messages;
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
    public function ruleExists(string $name): bool
    {
        return isset($this->rules[$name]);
    }

    /**
     * @param RuleInterface $rule
     * @return $this
     */
    public function addRule(RuleInterface $rule): self
    {
        $this->rules[$rule->getName()] = $rule;
        return $this;
    }

    /**
     * @param RuleInterface $rules
     * @return $this
     */
    public function addRules(iterable $rules): self
    {
        foreach ($rules as $rule)
        {
            $this->addRule($rule);
        }

        return $this;
    }
}
