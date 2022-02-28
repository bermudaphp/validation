<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Clock\Clock;

class Date implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Value must be a valid date', protected ?string $format = null)
    {
        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        try {
            return $var instanceof \DateTimeInterface || Clock::create($var, format: $this->format) instanceof \DateTimeInterface;
        } catch (\Throwable) {
            return false;
        }
    }
    
    public static function between(\DateTimeInterface $min, \DateTimeInterface $max, ?string $format = null): self
    {
        return new class('Value must be a valid date between :min and :max', $format, $min, $max) extends Date {
            public function __construct(string $message = 'Value must be a valid date', ?string $format = null)
            {
                parent::__construct($message, $format);
                $this->wildcards[':min'] = $min; $this->wildcards[':max'] = $max;
            }
            
            protected function doValidate($var): bool
            {
                if (!parent::doValidate($var)) {
                    return false;
                }
                
                if ($var instanceof \DateTimeInterface) {
                    $var = Clock::create($var, $this->format);
                }
                
                return $this->wildcards[':min'] >= $var && $var <= $this->wildcards[':max'];
            }
        };
    }
}
