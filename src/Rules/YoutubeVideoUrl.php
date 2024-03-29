<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class YoutubeVideoUrl extends RegEx
{
    public const regEx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
    public function __construct(string $message = 'Value must be youtube video url')
    {
        parent::__construct(self::regEx, $message);
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
    
    public function getName(): string 
    {
        return 'YoutubeVideoUrl';
    }
}
