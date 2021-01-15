<?php

namespace Bermuda\Validation\Rules;

/**
 * Class AbstractRule
 * @package Bermuda\Validation\Rules
 */
abstract class AbstractRule implements RuleInterface
{    
    use RuleTrait ;
    protected string $msg = '';
    
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
        
        return  $result ? $this->validateNext($value) : $this->getMessage($value);
    }
    
    public function setMessage(string $msg): void
    {
        $this->msg = $msg;
    }
    
    protected function getMessage($value): array
    {
        if ($this->msg = '')
        {
            return $this->getMessageFor($value);
        }
        
        $msg = $this->msg; $this->msg = '';
        
        return [$msg];
    }
     
    abstract protected function validate(&$value): bool ;
    abstract protected function getMessageFor($value): string ;
}
