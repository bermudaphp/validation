<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Utils\Byte;
use Bermuda\Detector\Detector;
use Bermuda\Detector\FinfoDetector;
use Psr\Http\Message\UploadedFileInterface;

final class Image implements RuleInterface
{
    use RuleTrait;
    private Detector $detector;
    private ?Byte $maxImageSize = null;
    private array $extensions = [];
    public function __construct(int|string $maxImageSize = null,
        private ?int $maxImageWidth = null, private ?int $maxImageHeight = null)
    {
        if ($maxImageSize != null) {
            $this->wildcards[':size'] = new Byte($maxImageSize);
        }

        $this->detector = new FinfoDetector;
    }

    public function getName(): string
    {
        return 'image';
    }

    public function setExtensions(string ...$extensions): self
    {
        $this->extensions = array_map('strtolower', $extensions);
        return $this;
    }

    public function setDetector(Detector $detector): self
    {
        $this->detector = $detector;
        return $this;
    }

    protected function doValidate($var): bool
    {
        if ($var instanceof UploadedFileInterface) {
            $var = $var->getStream()->getMetadata('uri');
        }

        if (!is_string($var) && !is_file($var) && !is_uploaded_file($var)) {
            return false;
        }

        if (!$this->wildcards[':size']?->lessThan(filesize($var))) {
            $this->message = 'Maximum image size exceeded, maximum size: :size';
            return false;
        }

        $mimeType = $this->detector->detectFileMimeType($var);

        if (!str_contains($mimeType, 'image')) {
            $this->message = 'Invalid mime-type: :mimeType. Allowed type: image/*';
            $this->wildcards[':mimeType'] = $mimeType;
            return false;
        }

        if ($this->extensions != [] && !in_array($ext = strtolower($this->detector->detectFileExtension($var)), $this->extensions)) {
            $this->message = 'Invalid file extension: :ext. Allowed extensions: :extensions';
            $this->wildcards[':extensions'] = implode(', ', $this->extensions);
            $this->wildcards[':ext'] = $ext;
            return false;
        }

        list($width, $height) = getimagesize($var);

        if ($this->maxImageWidth != null && $width > $this->maxImageWidth) {
            $this->message = 'The maximum image width has been exceeded. Maximum width: :width px';
            $this->wildcards[':width'] = $this->maxImageWidth;
            return false;
        }

        if ($this->maxImageHeight != null && $height > $this->maxImageHeight) {
            $this->message = 'The maximum image height has been exceeded. Maximum height: :height px';
            $this->wildcards[':height'] = $this->maxImageHeight;
            return false;
        }

        return true;
    }
}
