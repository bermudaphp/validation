<?php

namespace Bermuda\Validation;


use Bermuda\Validation\Rules\RuleInterface;


/**
 * @param array $data
 * @return Validator
 */
function v(array $data = []): Validator
{
    return Validator::make($data);
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
        $previous['class'] = get_class($rule);

        throw new ValidationException($previous, $errors);
    }
}
