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
        foreach (is_string($messages) ? [$messages] : $messages as $name => $message) {
            $this->messages[$name] = $message;
        }

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

        foreach ($this->errors as $error) {
            if (str_contains($error, $this->valueWildcard)) {
                $wildcards[$this->valueWildcard] = $this->prepareVar($var);
                break;
            }
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
        $errors = $this->errors; 
        $this->errors = [];
        
        if ($errors == [] && count($this->messages) == 1) {
            return str_replace(array_keys($wildcards), $wildcards, $this->messages[0]);
        }
        
        foreach($errors as $i => $error) {
            $errors[$i] = str_replace(array_keys($wildcards), $wildcards, $error);
        }
        
        return $i > 0 ? $errors : $errors[0];
    }
}
