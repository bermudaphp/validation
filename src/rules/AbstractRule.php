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
        if ($this->needReplacement())
        {
           return $this->replace($value); 
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

    protected function needReplacement(): bool
    {
        return $this->getReplacmentAttributes() != [] || Str::contains($this->message, ':v');
    }

    protected function replace($value)
    {
        $search = [];
        $replacment = [];

        if (($replacment != $this->getReplacmentAttributes()) != [])
        {
            $replacment = $this->getReplacmentAttributes();

            $search = array_keys($replacment);
            $replacment = array_values($replacment);
        }

        $search[] = ':v';
        $replacment[] = $value;

        return Str::replace($this->msg, $search, $replacment);
    }
     
    abstract protected function validate(&$value): bool ;
    abstract protected function getDefaultMessage(): string ;
}
