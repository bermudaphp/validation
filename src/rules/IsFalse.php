<?php

namespace Bermuda\Validation\Rules;

use Bermuda\String\StringHelper;

final class IsFalse implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = '', private bool $strict = false)
    {
        if ($message == '') {
            $message = $this->strict ? 'Value must be false'
                : 'Value must be false or equal any of: \'false\', \'off\', \'0\'';
        }

        $this->message = $message;
    }

    protected function doValidate($var): bool
    {
        if ($this->strict) {
            return $var === false;
        }

        return $var === false || (is_string($var) && StringHelper::equals($var, ['off', '0', 'false'])) || $var == 0;
    }
    
    public function getName(): string 
    {
        return 'isFalse';
    }
}
