<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;

/**
 * @param RuleInterface[] $rules
 * @return Validator
 */
function v(iterable $rules = []): Validator
{
    return new Validator($rules);
}

/**
 * @param RuleInterface $rule
 * @return void
 * @throws ValidationException
 */
function validate(RuleInterface $rule, $value): void
{
    $errors = $rule($value);
    
    if ($errors != [])
    {
        $previous = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0];
        $previous['function'] = __FUNCTION__;
        unset($previous['class']);

        throw new ValidationException($previous, $errors);
    }
}
