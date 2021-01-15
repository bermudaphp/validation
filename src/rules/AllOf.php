<?php

namespace Bermuda\Validation\Rules;

/**
 * Class AllOf
 * @package Bermuda\Validation\Rules
 */
final class AllOf extends OneOf
{
    private bool $break;

    /**
     * AllOf constructor.
     * @param RuleInterface[] $rules
     * @param bool $break
     */
    public function __construct(iterable $rules = [], bool $break = false)
    {
        $this->break = $break;
        parent::__construct($rules);
    }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        $messages = [];

        foreach ($this as $rule)
        {
            if (($failure = $rule($value)) != [])
            {
                $messages = array_merge($messages, $failure);

                if ($this->break)
                {
                    return $messages;
                }
            }
        }

        return $messages;
    }

    /**
     * @param RuleInterface[]|RuleInterface $rule
     * @param bool $break
     * @return static
     */
    public static function make($rule, bool $break = false): self
    {
        return new self((array) $rule, $break);
    }
    
    /**
     * @param RuleInterface[]|RuleInterface $rule
     * @return static
     */
    public static function breakF($rule): self
    {
        return static::make($rule, true);
    }
}
