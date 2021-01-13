<?php

namespace Bermuda\Validation\Rules;


/**
 * Class AbstractRule
 * @package Bermuda\Validation\Rules
 */
abstract class AbstractRule implements RuleInterface
{
    use RuleTrait { validateNext as protected; }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        return $this->validate($value) ? $this->validateNext($value) : $this->getMessageFor($value);
    }
    
    abstract protected function validate($value): bool ;
    abstract protected function getMessageFor($value): array ;
}
