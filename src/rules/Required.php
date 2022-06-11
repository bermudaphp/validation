<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Validation\ValidationException;

/**
 * @method string|bool validate
 */
final class Required implements RuleInterface, ValidationDataAwareInterface
{
    use RuleTrait, ValidationDataTrait;
    public function __construct(private string $columnName)
    {
        $this->messages[] = "$columnName is required";
    }

    protected function doValidate($var): bool
    {
        if ($this->data === null) throw new NullValidationDataException;
        return isset($this->data[$this->columnName]);
    }

    public function getName(): string
    {
        return 'required';
    }
}
