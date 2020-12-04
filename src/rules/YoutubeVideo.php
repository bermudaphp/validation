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
    
    /**
     * @param string $regExp
     * @return $this
     */
    public function withExp(string $regExp): self
    {
        throw new \RuntimeException(__METHOD__ . ' is dissable from this class');
    }
}
