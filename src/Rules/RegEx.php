<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Stdlib\StrHelper;

/**
 * @method string|bool validate 
 */
class RegEx implements RuleInterface
{
    use RuleTrait;
    public function __construct(protected string $exp, string $message = 'Value must be match the regular expression: :exp')
    {
        $this->messages[] = $message;
        $this->wildcards[':exp'] = $this->exp = $exp;
    }

    /**
     * @return string
     */
    public function getExp(): string
    {
        return $this->exp;
    }

    /**
     * @param string $exp
     * @return static
     */
    public function withExp(string $exp): self
    {
        $copy = clone $this;
        $copy->exp = $exp;
        
        return $copy;
    }

    protected function doValidate($var): bool
    {
        if (!is_string($var)) {
            return false;
        }
        
        return StrHelper::match($this->exp, $var);
    }
    
    public function getName(): string 
    {
        return 'regEx';
    }
}
