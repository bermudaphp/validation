<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;
use Bermuda\Validation\Rules\RuleCollectionInterface;

/**
 * @param iterable<RuleInterface|RuleCollectionInterface> $rules
 * @return Validator
 * @throws ValidationException
 */
function v(iterable $rules = []): Validator
{
    return new Validator($rules);
}

