<?php


namespace Bermuda\Validation\Rules;


/**
 * Class Datetime
 * @package Bermuda\Validation\Rules
 */
final class Date implements RuleInterface
{
    use RuleTrait;

    /**
     * @param $value
     * @return array
     */
    public function __invoke($value): array
    {
        try
        {
            if (!$value instanceof \DateTimeInterface)
            {
                new \DateTime($value);
            }
        }

        catch (\Throwable $e)
        {
            return ['The value must be a DateTime string'];
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
}
