<?php


namespace Bermuda\Validation;


/**
 * @param array $data
 * @return Validator
 */
function v(array $data = []): Validator
{
    return Validator::make($data);
}
