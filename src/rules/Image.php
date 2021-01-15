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
        $this->maxFileSize = $maxImageSize;
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
                list($width, $height) = getimagesize($value);
                
                if ($this->maxImageWidth != null && $this->maxImageWidth < $width)
                {
                    $this->msg = sprintf('Image width must be less than %s px', $this->maxImageWidth);
                    return false;
                }
                
                if ($this->maxImageHeight != null && $this->maxImageHeight < $height)
                {
                    $this->msg = sprintf('Image height must be less than %s px', $this->maxImageHeight);
                    return false;
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
}
