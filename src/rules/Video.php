<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;

class Video implements RuleInterface
{
    public function getName(): string
    {
        return 'video';
    }

    /**
     * @param $value
     * @return array
     */
    public function validate($value): array
    {
        if (str_contains($value, 'https://www.youtube.com/watch?'))
        {
            return [];
        }

        return ['Video format is not available!'];
    }
}