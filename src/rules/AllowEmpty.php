<?php

namespace Bermuda\Validation\Rules;

/**
 * Class AllowEmpty
 * @package Bermuda\Validation\Rules
 */
final class AllowEmpty implements RuleInterface
{
    use RuleTrait;
    
    public function __construct(?RuleInterface $next = null)
    {
        $this->setNext($next);
    }
    
    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return !empty($value) ? $this->validateNext($value) : [];
    }

    /**
     * @param RuleInterface|null $rule
     * @return static
     */
    public static function make(?RuleInterface $rule = null): self
    {
        return new self($rule);
    }

    /**
     * @param RuleInterface|RuleInterface[] $rule
     * @return AllOf
     */
    public static function allOf($rule): self
    {
        return new self(AllOf::make($rule));
    }

    /**
     * @param RuleInterface|RuleInterface[] $rule
     * @return OneOf
     */
    public static function oneOf($rule): self
    {
        return new self(OneOf::make($rule));
    }
}
