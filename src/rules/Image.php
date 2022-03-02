<?php

namespace Bermuda\Validation\Rules;

final class Image extends File
{
    public function __construct(int|string $maxImageSize = null,
        private ?int $maxImageWidth = null, private ?int $maxImageHeight = null)
    {
        parent::__construct($maxImageSize);
        $this->messages['width'] = 'The maximum image width has been exceeded. Maximum width: :width px';
        $this->messages['height'] = 'The maximum image height has been exceeded. Maximum height: :height px';
        $this->mimeTypes = ['image'];
    }

    public function getName(): string
    {
        return 'image';
    }

    protected function doValidate($var): bool
    {
       parent::validate($var);
       list($width, $height) = getimagesize($var);

       if ($this->maxImageWidth != null && $width > $this->maxImageWidth) {
           $this->errors[] = $this->messages['width'];
           $this->wildcards[':width'] = $this->maxImageWidth;
       }

       if ($this->maxImageHeight != null && $height > $this->maxImageHeight) {
           $this->errors[] = $this->messages['height']; 
           $this->wildcards[':height'] = $this->maxImageHeight;
       }

       return $this->errors == [];
    }
}
