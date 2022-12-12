<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class LessThanEquals implements RuleInterface
{
    use RuleTrait;
    public function __construct(float|int $operand, string $message = 'Value must be less than or equal to :operand')
    {
        $this->messages[] = $message;
        $this->wildcards[':operand'] = $operand;
    }

    protected function doValidate($var): bool
    {
        if (!is_numeric($var)) {
            return false;
        }

        return $this->wildcards[':operand'] >= $var;
    }
    
    public function getName(): string 
    {
        return 'lessThanEquals';
    }
}
