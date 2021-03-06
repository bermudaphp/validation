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
    protected string $msg = '';

    public function __construct(string $msg = '')
    {
        $this->msg = $msg;
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
    
    protected function getMessage($value):string
    {
        if ($this->needReplacement())
        {
           return $this->replace($value); 
        }

        return $this->msg;
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
        return false;
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
}
