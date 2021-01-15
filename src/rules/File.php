<?php

namespace Bermuda\Validation\Rules;

/**
 * Class UploadedFile
 * @package Bermuda\Validation\Rules
 */
class File extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return is_uploaded_file($value);
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a file';
    }
}
