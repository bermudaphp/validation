<?php

namespace Bermuda\Validation\Rules;

final class NotEmpty implements RuleInterface
{
    use RuleTrait;
    public function __construct(string $message = 'Must be not empty')
    {
        $this->message = 'Must be not empty';
    }

    protected function doValidate($var): bool
    {
        return !empty($var);
    }

    /**
     * @param string $message
     * @return RuleInterface
     */
    public static function revers(string $message = 'Must be empty'): RuleInterface
    {
        return new class($message) implements RuleInterface
        {
            use RuleTrait;
            public function __construct(string $message)
            {
                $this->message = $message;
            }
            protected function doValidate($var): bool
            {
                return empty($var);
            }
        };
    }
}
