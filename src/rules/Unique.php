<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Validation\Rules\RuleInterface;
use Bermuda\Validation\Rules\RuleTrait;

final class Unique implements RuleInterface
{
    use RuleTrait;
    private \Closure $isUnique;
    public function __construct(callable $isUnique, string $message = 'Must be unique')
    {
        $this->messages[] = $message;
        $this->isUnique = static function($var) use ($isUnique): bool {
            return $isUnique($var);
        };
    }

    public function getName(): string
    {
        return 'unique';
    }

    protected function doValidate($var): bool
    {
        return ($this->isUnique)($var);
    }
}
