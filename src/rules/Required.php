<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Validation\ValidationException;

/**
 * @method string|bool validate
 */
final class Required implements RuleInterface, ValidationDataAwareInterface
{
    use RuleTrait, ValidationDataTrait;
    public function __construct(private string $columnName, ?string $message = null)
    {
        $this->messages[] = $message === null ? "$columnName is required" : $message;
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
