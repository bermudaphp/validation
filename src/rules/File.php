<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Utils\Byte;
use Bermuda\Detector\Detector;
use Bermuda\Detector\FinfoDetector;
use Psr\Http\Message\UploadedFileInterface;
use function Bermuda\String\str_contains;

class File implements RuleInterface
{
    use RuleTrait;
    protected Detector $detector;
    protected array $extensions = [];
    protected array $mimeTypes = [];
    public function __construct(int|string $filesize = null, array $messages = [])
    {
        if ($filesize != null) {
            $this->wildcards[':size'] = new Byte($filesize);
        }
        
        if ($messages == []) {
            $messages = [
                'file' => 'Must be file',
                'mimeType' => 'Invalid mime-type: :mimeType. Allowed types: :mimeTypes',
                'filesize' => 'Maximum file size exceeded, maximum size: :size',
                'extension' => 'Invalid file extension: :ext. Allowed extensions: :extensions'
            ];
        }

        $this->messages = $messages;
        $this->detector = new FinfoDetector;
    }

    public function getName(): string
    {
        return 'file';
    }

    public function setExtensions(string ...$extensions): self
    {
        $this->extensions = array_map('strtolower', $extensions);
        return $this;
    }

    public function setMimeTypes(string ...$types): self
    {
        $this->mimeTypes = array_map('strtolower', $types);
        return $this;
    }

    public function setDetector(Detector $detector): self
    {
        $this->detector = $detector;
        return $this;
    }

    protected function doValidate($var): bool
    {
        $this->isFile($var);
        $this->validateFilesize($var);
        $this->validateMimeType($var);
        $this->validateExtension($var);
        
        return $this->errors == [];
    }

    protected function validateMimeType(string $filename): void
    {
        $mimeType = $this->detector->detectFileMimeType($filename);

        if ($this->mimeTypes != [] && str_contains($mimeType, $this->mimeTypes)) {
            $this->errors[] = $this->messages['mimeType'];
            $this->wildcards[':mimeType'] = $mimeType;
            $this->wildcards[':mimeTypes'] = implode(', ', $this->mimeTypes);
        }
    }

    protected function validateFilesize(string $filename): void
    {
        if (!$this->wildcards[':size']?->lessThan(filesize($var))) {
            $this->errors[] = $this->messages['filesize'];
        }
    }
    
    protected function isFile($var): void
    {
        if ($var instanceof UploadedFileInterface) {
            $var = $var->getStream()->getMetadata('uri');
        }

        if (!is_string($var) && !is_file($var) && !is_uploaded_file($var)) {
            $this->errors[] = $this->messages['file'];
        }
    }

    protected function validateExtension(string $filename): void
    {
        if ($this->extensions != [] && !in_array($ext = strtolower($this->detector->detectFileExtension($var)), $this->extensions)) {
            $this->errors[] = $this->messages['extension'];
            $this->wildcards[':extensions'] = implode(', ', $this->extensions);
            $this->wildcards[':ext'] = $ext;
        }
    }
}
