<?php

namespace Bermuda\Validation\Rules;

/**
 * Class File
 * @package Bermuda\Validation\Rules
 */
class File extends AbstractRule
{
    protected ?int $maxFileSize = null;

    public function __construct(?int $maxFileSize = null)
    {
        if ($maxFileSize != null)
        {
            $this->setNext(new Filesize($maxFileSize));
        }
        parent::__construct(null);
    }
    
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
    protected function getDefaultMessage(): string
    {
        return 'Must be a file';
    }
}
