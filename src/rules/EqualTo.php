<?php

namespace Bermuda\Validation\Rules;

/**
 * @method string|bool validate 
 */
final class EqualTo implements RuleInterface
{
    use RuleTrait;
    public function __construct(private int|float|string $operand, string $message = 'Must be equal to :operand', private bool $strict = true)
    {
        $this->messages[] = $message;
        $this->wildcards[':operand'] = (string) $this->operand;
    }

    protected function doValidate($var): bool
    {
        return $this->strict ? $var === $this->operand : $var == $this->operand;
    }
    
    public function getName(): string 
    {
        return 'equalTo';
    }
}
