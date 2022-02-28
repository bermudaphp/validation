<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Clock\Clock;

class Date implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a valid date:format', protected ?string $format = null)
    {
        $this->message = $message;
        $this->wildcards[':format'] = $format == null ? '' : ' in format: ' . $format;
    }

    protected function doValidate($var): bool
    {
        try {
            return $var instanceof \DateTimeInterface || Clock::create($var, format: $this->format) instanceof \DateTimeInterface;
        } catch (\Throwable) {
            return false;
        }
    }

    public static function concrete(\DateTimeInterface $date, string $message ='Value must be a valid date:format equal to :date', ?string $format = null): self
    {
        return new class($date, $message, $format) extends Date {
            public function __construct(\DateTimeInterface $date, string $message, ?string $format)
            {
                parent::__construct($message, $format);
                $this->wildcards[':date'] = $date;
            }

            protected function doValidate($var): bool
            {
                if (!parent::doValidate($var)) {
                    return false;
                }

                if (!$var instanceof \DateTimeInterface) {
                    $var = Clock::create($var, $this->format);
                }

                return $var == $this->wildcards[':date'];
            }
        };
    }

    /**
     * @param \DateTimeInterface[] $dates
     * @param string $message
     * @param string|null $format
     * @return static
     */
    public static function any(array $dates, string $message ='Value must be a valid date:format equal to any: :dates', ?string $format = null): self
    {
        return new class($dates, $message, $format) extends Date {
            public function __construct(array $dates, string $message, ?string $format)
            {
                parent::__construct($message, $format);
                $this->wildcards[':dates'] = $dates;
            }

            protected function doValidate($var): bool
            {
                if (!parent::doValidate($var)) {
                    return false;
                }

                if (!$var instanceof \DateTimeInterface) {
                    $var = Clock::create($var, $this->format);
                }

                foreach ($this->wildcards[':dates'] as $date) {
                    if ($date == $var) {
                        return true;
                    }
                }

                return false;
            }

            protected function getWildcards($var): array
            {
                $wildcards = parent::getWildcards($var);
                $dates = $wildcards[':dates'];
                $wildcards[':dates'] = '[';
                $delim = '';

                foreach ($dates as $date) {
                    $wildcards[':dates'] .= $delim;
                    if ($this->format != null) {
                        $wildcards[':dates'] .= $date->format($this->format);
                    } else {
                        $wildcards[':dates'] .= $date;
                    }
                    $delim = ', ';
                }

                $wildcards[':dates'] .= ']';

                return $wildcards;
            }
        };
    }

    public static function between(\DateTimeInterface $min, \DateTimeInterface $max, string $message ='Value must be a valid date:format between :min and :max', ?string $format = null): self
    {
        return new class($min, $max, $message, $format) extends Date {
            public function __construct(\DateTimeInterface $min, \DateTimeInterface $max, string $message, ?string $format)
            {
                parent::__construct($message, $format);
                $this->wildcards[':min'] = $min; $this->wildcards[':max'] = $max;
            }

            protected function doValidate($var): bool
            {
                if (!parent::doValidate($var)) {
                    return false;
                }

                if (!$var instanceof \DateTimeInterface) {
                    $var = Clock::create($var, $this->format);
                }

                return $var >= $this->wildcards[':min'] && $this->wildcards[':max'] >= $var;
            }
        };
    }
}
