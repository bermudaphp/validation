<?php

namespace Bermuda\Validation\Rules;

/**
 * Class Filesize
 * @package Bermuda\Validation\Rules
 */
class Filesize extends AbstractRule
{
    protected int $maxFileSize;

    public function __construct(?int $maxFileSize = null)
    {
        $this->maxFileSize = $maxFileSize;
    }
    
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        return $this->maxFileSize >= filesize($value);
    }
    
    /**
     * @return array
     */
    protected function getReplacmentAttributes(): array
    {
        return [':size' => $this->maxFileSize];
    }
    
    /**
     * @inheritDoc
     */
    protected function getDefaultMessage(): string
    {
        return 'File size must be less than or equals :size b. File size: :v';
    }
}
