<?php

namespace Bermuda\Validation;

use Bermuda\Validation\Rules\RuleInterface;

/**
 * @param RuleInterface[] $rules
 * @return Validator
 * @throws ValidationException
 */
function v(iterable $rules = [], ?array $data = null): Validator
{
    $v = Validator::makeOf($rules);
    
    if ($data != null)
    {
        $v->validate($data);
    }
    
    return $v
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
