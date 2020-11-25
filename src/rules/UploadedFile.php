<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class UploadedFile
 * @package App\Validator\Rules
 */
class UploadedFile implements RuleInterface
{
    public function getName(): string
    {
        return 'uploadedFile';
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if (!is_uploaded_file($value))
        {
            return ['Value is not uploaded!'];
        }

        return [];
    }
}