<?php


namespace Bermuda\Validation\Rules;


/**
 * Class IsBool
 * @package Bermuda\Validation\Rules
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
