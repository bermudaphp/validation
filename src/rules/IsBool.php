<?php


namespace App\Validator\Rules;


use App\Validator\RuleInterface;


/**
 * Class IsBool
 * @package App\Chain\Rules
 */
class IsBool implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'isBool';
    }

    /**
     * @inheritDoc
     */
    public function validate($value): array
    {
        return !is_bool($value) ? ['Value must be a boolean type!'] : [];
    }
}