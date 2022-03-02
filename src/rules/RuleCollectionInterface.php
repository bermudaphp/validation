<?php

namespace Bermuda\Validation\Rules;

use Traversable;
use IteratorAggregate;

interface RuleCollectionInterface extends RuleInterface, IteratorAggregate
{
    /**
     * @param RuleInterface $rule
     * @return RuleCollectionInterface
     */
    public function addRule(RuleInterface $rule): RuleCollectionInterface ;

    /**
     * @param string|RuleInterface $rule
     * @return bool
     */
    public function hasRule(string|RuleInterface $rule): bool ;

    /**
     * @return Traversable<RuleInterface>
     */
    public function getIterator(): Traversable;
}
