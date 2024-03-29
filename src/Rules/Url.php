<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class Url extends RegEx
{
    public const regEx ='%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
    public function __construct(string $message = 'Value must be correct url')
    {
        parent::__construct(self::regEx, $message);
    }

    /**
     * @return string
     */
    public function getExp(): string
    {
        return $this->exp;
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
        return 'url';
    }
}
