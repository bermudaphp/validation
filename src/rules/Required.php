<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate
 */
final class Required implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $columnName)
    {
        $this->messages[] = "$columnName is required";
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            $this->errors[] = 'Must be a string';
            return false;
        }
        
        return !empty(trim($var));
    }

    public function getName(): string
    {
        return 'required';
    }
}
