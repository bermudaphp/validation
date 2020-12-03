<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;

class Video implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if (str_contains($value, 'https://www.youtube.com/watch?'))
        {
            return [];
        }

        return ['Video format is not available!'];
    }
}