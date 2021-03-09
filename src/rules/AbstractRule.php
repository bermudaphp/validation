<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\Str;

/**
 * Class AbstractRule
 * @package Bermuda\Validation\Rules
 */
abstract class AbstractRule implements RuleInterface
{
    use RuleTrait ;
    protected string $message;

    public function __construct(?string $message = null)
    {
        $this->message = $message ?? $this->getDefaultMessage();
    }
    
    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        try
        {
            $result = $this->validate($value);
        }
        
        catch(\Throwable $e)
        {
            $result = false;
        }
        
        return  $result ? $this->validateNext($value) : [$this->getMessage($value)];
    }
    
    /**
     * @param $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->msg = $message;
        return $this;
    }
    
    protected function getMessage($value): string
    {
        $attributes = $this->getReplacmentAttributes();

        $tokens = array_keys($attributes);
        $tokens[] = ':v';

        $values = array_values($attributes);
        $values[] = $value;

        if (Str::containsAny($this->message, $tokens))
        {
           return Str::replace($this->message, $tokens, $values);
        }

        return $this->message;
    }

    /**
     * @return array
     */
    protected function getReplacmentAttributes(): array
    {
        return [];
    }
    
    abstract protected function validate(&$value): bool ;
    abstract protected function getDefaultMessage(): string ;
}
