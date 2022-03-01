<?php

namespace Bermuda\Validation\Rules;

final class YoutubeVideoUrl extends RegEx
{
    public const regEx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
    public function __construct(string $message = 'Value must be youtube video url')
    {
        parent::__construct(self::regexp, $message);
    }
    
    /**
     * @param string $exp
     * @return self
     * @throws \RuntimeException
     */
    public function withExp(string $exp): self
    {
        throw new \RuntimeException(__METHOD__ . ' is dissable from this class');
    }
}
