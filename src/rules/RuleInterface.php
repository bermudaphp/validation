<?php

namespace Bermuda\Validation\Rules;

interface RuleInterface
{
    /**
     * @param $value
     * @return bool|string
     * Returns true if the validation was successful otherwise returns an error message
     */
    public function validate($value): bool|string ;

    /**
     * @param RuleInterface|null $rule
     * @return RuleInterface
     */
    public function setNext(?RuleInterface $rule): RuleInterface ;

    /**
     * @return $this
     */
    public function setMessage(string $message): RuleInterface ;
}
