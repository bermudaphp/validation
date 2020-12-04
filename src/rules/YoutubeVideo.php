<?php

namespace Bermuda\Validation\Rules;


use Bermuda\String\Str;


/**
 * Class YoutubeVideo
 * @package Bermuda\Validation\Rules
 */
final class YoutubeVideo extends RegExp
{
    public const regexp = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';

    public function __construct()
    {
        parent::__construct(self::regexp);
    }
}
