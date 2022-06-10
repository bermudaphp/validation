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
        if (empty($var) || (is_string($var) && empty(trim($var)))) {
            return false;
        }
        
        return true;
    }

    public function getName(): string
    {
        return 'required';
    }
}
