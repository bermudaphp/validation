<?php

namespace Bermuda\Validation\Rules;

/**
 * Trait DateTimeFactoryAwareTrait
 * @package Bermuda\Validation\Rules
 */
trait DateTimeFactoryAwareTrait
{
    private $dateTimeFactory = null;
    private string $dateTimeFormat = 'd/m/Y';

    /**
     * @param callable $factory
     */
    public function setDatetimeFactory(callable $factory): void
    {
        $this->dateTimeFactory = static function($v, ?string $format = null) use ($factory): \DateTimeInterface
        {
            return $factory($v, $format);
        };
    }

    /**
     * @return mixed
     */
    public function getDateTimeFactory(): callable
    {
        if ($this->dateTimeFactory == null)
        {
            return static function($v, ?string $format = null): \DateTime
            {
                return \DateTime::createFromFormat($format, $v);
            };
        }

        return $this->dateTimeFactory;
    }

    /**
     * @param string $format
     */
    public function setDatetimeFormat(string $format): void
    {
        $this->datetimeFormat = $format;
    }
}
