<?php

namespace Bermuda\Validation\Rules;

trait RuleTrait
{
    protected string $message = '';
    protected ?array $wildcards = [];
    protected string $valueWildcard = ':v';

    /**
     * @param string $pattern
     * @return RuleInterface
     */
    public function setMessage(string $pattern): RuleInterface
    {
        $this->message = $pattern;
        return $this;
    }

    /**
     * @inerhitDoc
     */
    public function validate($var): bool|string
    {
        if (($result = $this->doValidate($var)) === true) {
            return true;
        }

        return $this->generateMessage($this->getWildcards($var));
    }

    protected function getWildcards($var): array
    {
        if (strpos($this->message, $this->valueWildcard) !== false) {
            $wildcards = [$this->valueWildcard => $this->prepareVar($var)];
        }
        
        if ($this->wildcards !== []) {
            $wildcards = array_merge($wildcards, $this->wildcards);
        }

        return $wildcards;
    }

    protected function prepareVar($var): string
    {
        return $var;
    }

    abstract protected function doValidate($var): bool;

    /**
     * @param array $wildcards
     * @return string
     */
    protected function generateMessage(array $wildcards): string
    {
        return str_replace(array_keys($wildcards), $wildcards, $this->message);
    }
}
