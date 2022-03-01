<?php

namespace Bermuda\Validation\Rules;

final class Numbers implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a array of numbers')
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if (!is_array($var)) {
            return false;
        }
        
        foreach ($var as $item) {
            if (!is_numeric($item)) {
                return false;
            }
        }
        
        return true;
    }
}
