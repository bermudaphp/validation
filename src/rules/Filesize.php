<?php

namespace Bermuda\Validation\Rules;

/**
 * Class File
 * @package Bermuda\Validation\Rules
 */
class Filesize extends AbstractRule
{
    protected int $maxFileSize;

    public function __construct(?int $maxFileSize = null)
    {
        $this->maxFileSize = $maxImageSize;
    }
    
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return $this->maxFileSize < filesize($value);
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return sprintf('File size must be less than %s b', $this->maxFileSize);
    }
}
