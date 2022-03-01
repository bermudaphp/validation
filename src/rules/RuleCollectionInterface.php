<?php

namespace Bermuda\Validation\Rules;

use Traversable;

interface RuleCollectionInterface extends \IteratorAggregate
{
    /**
     * @param $value
     * @return bool|string|string[]
     * Returns true if the validation was successful otherwise returns an error message or array of errors
     */
    public function validate($value): bool|string|array ;
    public function addRule(RuleInterface $rule): RuleCollectionInterface ;
    public function hasRule(string|RuleInterface $rule): bool ;
    /**
     * @return Traversable<RuleInterface>
     */
    public function getIterator(): Traversable ;
}
