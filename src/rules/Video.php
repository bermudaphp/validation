<?php

namespace Bermuda\Validation\Rules;


class YoutubeVideo implements RuleInterface
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
