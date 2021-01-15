<?php

namespace Bermuda\Validation\Rules;

/**
 * Class Numbers
 * @package Bermuda\Validation\Rules
 */
final class Numbers extends Number
{
   /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        foreach($value as $v)
        {
            if (!parent::validate($v))
            {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a array of numbers';
    }
}
