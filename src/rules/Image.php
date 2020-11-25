<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Image
 * @package App\Validator\Rules
 */
class Image implements RuleInterface
{
    private ?int $size = null, $width = null, $height = null;

    public function __construct(
        ?int $size = null,
        int $width = null,
        ?int $height = null
    )
    {
        $this->size = $size;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'image';
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if (@(string) is_file($value))
        {
            $mime = (string) finfo_file(
                finfo_open(FILEINFO_MIME_TYPE),
                $value
            );

            if (str_contains($mime, 'image'))
            {
                if ($this->size != null && $this->size < filesize($value))
                {
                    return [sprintf('File size must be less than %s b', $this->size)];
                }

                return [];
            }
        }

        return ['Value must be a image!'];
    }
}