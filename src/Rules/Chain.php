<?php

namespace Bermuda\Validation\Rules;

use Bermuda\Validation\NullValidationDataException;

final class Сhain implements RuleCollectionInterface, ValidationDataAwareInterface
{
    use RuleCollectionTrait, ValidationDataTrait;
    /**
     * @inerhitDoc
     */
    public function validate($value): bool|string
    {
        if ($this->data === null) throw new NullValidationDataException;
        foreach ($this->rules as $rule) {
            if ($rule instanceof ValidationDataAwareInterface) $rule->setData($this->data);
            if (($result = $rule->validate($value)) !== true) {
                return $result;
            }
        }
        
        return true;
    }

    public function getName(): string
    {
        return 'chain';
    }
}
