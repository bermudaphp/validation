<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class Datetime
 * @package App\Validator\Rules
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

            return $this->validateNext($value);
        }

        catch (\Throwable $e)
        {
            return ['The value must be a DateTime string'];
        }
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