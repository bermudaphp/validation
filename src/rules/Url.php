<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\Str;

/**
 * Class Url
 * @package Bermuda\Validation\Rules
 */
final class Url extends RegExp
{
    public const regexp ='%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu';
    public function __construct()
    {
        parent::__construct(self::regexp);
    }

    /**
     * @return string
     */
    public function getExp(): string
    {
        return $this->exp;
    }

    /**
     * @param string $regExp
     * @return $this
     */
    public function withExp(string $regExp): self
    {
        throw new \RuntimeException(__METHOD__ . ' is dissable from this class');
    }
    
    /**
     * @inheritDoc
     */
    protected function getMessageFor($value): string
    {
        return 'Must be a correct url';
    }
}
