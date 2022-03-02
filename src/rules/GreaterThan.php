<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class GreaterThan implements RuleInterface
{
    use RuleTrait;
    public function __construct(float|int $operand, string $message = 'Value must be greater than :operand')
    {
        $this->messages[] = $message;
        $this->wildcards[':operand'] = $operand;
    }

    protected function doValidate($var): bool
    {
        if (!is_numeric($var)) {
            return false;
        }

        return $var > $this->wildcards[':operand'];
    }
    
    public function getName(): string 
    {
        return 'greaterThan';
    }
}
