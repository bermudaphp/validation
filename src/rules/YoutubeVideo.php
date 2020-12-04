<?php

namespace Bermuda\Validation\Rules;


use Bermuda\String\Str;


/**
 * Class YoutubeVideo
 * @package Bermuda\Validation\Rules
 */
class YoutubeVideo implements RuleInterface
{
    use RuleTrait;

    public const regexp = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if (Str::match(self::regexp, (string) $value))
        {
            return $this->validateNext($value);
        }

        return [sprintf('The value must match the regular expression: %s', self::regexp)];
    }
}
