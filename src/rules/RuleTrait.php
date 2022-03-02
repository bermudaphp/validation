<?php

namespace Bermuda\Validation\Rules;

trait RuleTrait
{
    protected array $errors = [];
    protected array $messages = [];
    protected ?array $wildcards = [];
    protected string $valueWildcard = ':v';

    /**
     * @param string|array $messages
     * @return RuleInterface
     */
    public function setMessages(string|array $messages): RuleInterface
    {
        $this->messages = $messages;
        return $this;
    }

    /**
     * @inerhitDoc
     */
    public function validate($var): bool|string|array
    {
        if (($result = $this->doValidate($var)) === true) {
            return true;
        }

        return $this->returnErrors($this->getWildcards($var));
    }

    protected function getWildcards($var): array
    {
        $wildcards = [];
        
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
     * @return string|string[]
     */
    protected function returnErrors(array $wildcards): string|array
    {
        $errors = []; $i = 0;
        
        foreach($this->errors as $error) {
            $errors[++$i] = str_replace(array_keys($wildcards), $wildcards, $error);
        }
        
        return $i > 1 ? $errors : $errors[$i];
    }
}
