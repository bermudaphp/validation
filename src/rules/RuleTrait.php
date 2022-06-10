<?php

namespace Bermuda\Validation\Rules;

use function Bermuda\String\str_contains;

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

        return $this->returnErrors($var);
    }

    protected function getWildcards($var): array
    {
        $wildcards = [];
        $wildcards[$this->valueWildcard] = $this->prepareVar($var);

        if ($this->wildcards !== []) {
            $wildcards = array_merge($wildcards, $this->wildcards);
        }

        return $wildcards;
    }

    protected function prepareVar($var): string
    {
        if (is_string($var) || $var === null || is_numeric($var) || $var instanceof \Stringable) {
            return (string) $var;
        }

        if (is_object($var)) {
            return 'object of class ' . $var::class;
        }

        if (is_resource($var)) {
            return 'resource';
        }
        
        return is_bool($var) ? 'boolean' : 'array';
    }

    abstract protected function doValidate($var): bool;

    /**
     * @param $var
     * @return string|array
     */
    protected function returnErrors($var): string|array
    {
        $errors = $this->errors; 
        $this->errors = [];
        
        if ($errors == [] && count($this->messages) == 1) {
            $wildcards = $this->getWildcards($var);
            if (str_contains($this->messages[0], array_keys($wildcards))) {
                return str_replace(array_keys($wildcards), $wildcards, $this->messages[0]);
            }
            
            return $this->messages[0];
        }

        $wildcards = $this->getWildcards($var);
        foreach($errors as $i => $error) {
            $errors[$i] = str_replace(array_keys($wildcards), $wildcards, $error);
        }
        
        return count($errors) == 1 ? $errors[0] : $errors;
    }
}
