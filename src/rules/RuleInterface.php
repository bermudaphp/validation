<?php

namespace Bermuda\Validation\Rules;

interface RuleInterface
{
    /**
     * @return string return name of rule
     */
    public function getName(): string ;

    /**
     * @param $value
     * @return bool|string|array
     * Returns true if the validation was successful otherwise returns an error message
     * or errors array
     */
    public function validate($value): bool|string|array ;
}
