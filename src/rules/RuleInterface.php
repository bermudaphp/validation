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
     * @return bool|string
     * Returns true if the validation was successful otherwise returns an error message
     */
    public function validate($value): bool|string ;

    /**
     * Set rule validation error message
     * @return $this
     */
    public function setMessage(string $message): RuleInterface ;
}
