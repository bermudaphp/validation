<?php

namespace Bermuda\Validation\Rules;


/**
 * Class UploadedFile
 * @package Bermuda\Validation\Rules
 */
class UploadedFile implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if (!is_uploaded_file($value))
        {
            return ['Value is not uploaded!'];
        }

        return [];
    }
}
