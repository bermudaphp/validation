<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\Str;

/**
 * Class Image
 * @package Bermuda\Validation\Rules
 */
final class Image extends File
{
    private $maxImageWidth = null, $maxImageHeight = null;

    public function __construct(?int $maxImageSize = null,
        int $maxImageWidth = null, ?int $maxImageHeight = null)
    {
        parent::__construct($maxImageSize);
        
        $this->maxImageWidth = $maxImageWidth;
        $this->maxImageHeight = $maxImageHeight;
    }
 
    /**
     * @inheritDoc
     */
    protected function validate(&$value): bool
    {
        if (parent::validate($value))
        {
            $mime = (string) finfo_file(finfo_open(FILEINFO_MIME_TYPE), $value);

            if (Str::contains($mime, 'image'))
            {
                if ($this->maxImageWidth != null)
                {
                    list($width, $height) = getimagesize($value);
                    $this->setNext($this->getNext($this->maxImageWidth, $width, sprintf('Image width must be less than or equals %s px', $this->maxImageWidth)));
                }
                
                if ($this->maxImageHeight != null)
                {
                    $this->setNext($this->getNext($this->maxImageHeight, $height ?? getimagesize($value)[1], sprintf('Image height must be less than or equals %s px', $this->maxImageHeight)));
                }
     
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a image';
    }
    
    private function getNext(int $x, int $y, string $msg): RuleInterface
    {
        return new class extends AbstractRule
        {
            private int $x, $y;
            
            public function __construct(int $x, int $y, string $msg)
            {
                $this->x = $x; $this->y = $y; 
                $this->setMessage($msg);
            }
            
            protected function validate(&$v): bool
            {
                return $this->x >= $this->y;
            }
        };
    }
}
