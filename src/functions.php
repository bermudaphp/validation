<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;

/**
 * @param iterable<RuleInterface> $rules
 * @return Validator
 * @throws ValidationException
 */
function v(iterable $rules = []): Validator
{
    return new Validator($rules);
}

