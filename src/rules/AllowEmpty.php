<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Validation\ValidationException;

final class AllowEmpty implements RuleInterface, ValidationDataAwareInterface
{
    use ValidationDataTrait;
    public function __construct(private string $columnName, private RuleInterface $nextRule) {
    }

    /**
     * @param $value
     * @return bool|string|array
     */
    public function validate($value): bool|string|array
    {
        if ($this->data === null) throw new NullValidationDataException;
        return !isset($this->data[$this->columnName]) ? true : $this->nextRule->validate($value);
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'allowEmpty';
    }
}
