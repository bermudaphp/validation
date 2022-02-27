<?php

namespace Bermuda\Validation\Rules;

trait RuleTrait
{
    protected string $message = '';
    protected ?array $wildcards = [];
    protected string $valueWildcard = ':v';
    protected ?RuleInterface $next = null;

    /**
     * @param RuleInterface|null $rule
     * @return RuleInterface
     */
    public function setNext(?RuleInterface $rule): RuleInterface
    {
        $this->next = $rule;
        return $rule;
    }

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
        if ($this->checkType($var) && ($result = $this->doValidate($this->prepareVar($var))) === true) {
            return $this->validateNext($var);
        }

        return $this->generateMessage($this->getWildcards($var));
    }

    protected function checkType($var): bool
    {
        return in_array(gettype($var), $this->getTypes());
    }

    protected function getTypes(): array
    {
        return ['string'];
    }

    protected function getWildcards($var): array
    {
        $wildcards = [$this->valueWildcard => $this->prepareVar($var)];

        if ($this->wildcards !== []) {
            $wildcards = array_merge($wildcards, $this->wildcards);
        }

        return $wildcards;
    }

    protected function prepareVar($var)
    {
        return $var;
    }

    abstract protected function doValidate($var): bool;

    /**
     * @param array $result
     * @param $value
     * @return array
     */
    protected function validateNext($value): bool|string
    {
        return $this->next?->validate($value) ?? true;
    }

    /**
     * @param array $wildcards
     * @return string
     */
    protected function generateMessage(array $wildcards): string
    {
        return str_replace(array_keys($wildcards), $wildcards, $this->message);
    }
}
