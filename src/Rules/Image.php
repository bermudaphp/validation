<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Detector\MimeTypes\Image as ImageMime;
use Psr\Http\Message\UploadedFileInterface;

final class Image extends File
{
    public function __construct(int|string $maxImageSize = null,
        private ?int $maxImageWidth = null, private ?int $maxImageHeight = null)
    {
        parent::__construct($maxImageSize);
        $this->messages['width'] = 'The maximum image width has been exceeded. Maximum width: :width px';
        $this->messages['height'] = 'The maximum image height has been exceeded. Maximum height: :height px';
        $this->mimeTypes = ImageMime::getTypes();
    }

    public function getName(): string
    {
        return 'image';
    }

    protected function doValidate($var): bool
    {
       if (parent::doValidate($var) == false) {
           return false;
       }

       if ($var instanceof UploadedFileInterface) {
           $var = $var->getStream()->getMetadata('uri');
       }

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
