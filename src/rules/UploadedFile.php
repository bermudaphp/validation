<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class UploadedFile
 * @package App\Validator\Rules
 */
class UploadedFile implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if (!is_uploaded_file($value))
        {
            return ['Value is not uploaded!'];
        }

        return [];
    }
}