<?php

namespace Bermuda\Validation\Rules;

/**
 * Class File
 * @package Bermuda\Validation\Rules
 */
class File extends AbstractRule
{
    protected ?int $maxImageSize = null;

    public function __construct(?int $maxFileSize = null)
    {
        $this->maxFileSize = $maxImageSize;
    }
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        if (is_uploaded_file($value))
        {
            return $this->checkMaxFileSize($value);
        }
        
        return false;
    }
    
    protected function checkMaxFileSize($value): bool
    {
        if ($this->maxFileSize != null && $this->maxFileSize < filesize($value))
        {
            $this->msg = sprintf('File size must be less than %s b', $this->maxFileSize);
            return false;
        }
        
        return true;
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a file';
    }
}
