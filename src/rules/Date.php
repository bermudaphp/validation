<?php


namespace Bermuda\Validation\Rules;


/**
 * Class Datetime
 * @package Bermuda\Validation\Rules
 */
final class Date implements RuleInterface
{
    use RuleTrait;

    private ?string $format = null;

    public function __construct(?string $format = null)
    {
        $this->format = $format;
    }

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        if ($value instanceof \DateTimeInterface)
        {
            return $this->validateNext($value);
        }

        try
        {
            $value = (string) $value;

            if ($this->format != null && \DateTime::createFromFormat($this->format, $value) !== false)
            {
                return $this->validateNext($value);
            }

            new \DateTime($value);
        }

        catch (\Throwable $e)
        {
            return [$this->getMessage()];
        }

        return $this->validateNext($value);
    }
    
    /**
     * @param \DateTimeInterface $dateTime
     * @param string $format
     * @return RuleInterface
     */
    public static function equalTo(\DateTimeInterface $dateTime, string $format = 'Y-m-d H:i:s'): RuleInterface
    {
        return (new self())->setNext(Equals::date($dateTime, $format));
    }

    /**
     * @return string
     */
    private function getMessage(): string
    {
        if ($this->format != null)
        {
            return 'The value must be a DateTimeInterface instance or string format: ' . $this->format;
        }

        return 'The value must be a DateTimeInterface instance or datetime string any format';
    }
}
