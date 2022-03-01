<?php

namespace Bermuda\Validation\Rules;

use Traversable;

interface RuleCollectionInterface extends \IteratorAggregate
{
    public function validate($value): bool|string|array ;
    public function addRule(RuleInterface $rule): RuleCollectionInterface ;
    public function hasRule(string|RuleInterface $rule): bool ;
    /**
     * @return Traversable<RuleInterface>
     */
    public function getIterator(): Traversable ;
}
