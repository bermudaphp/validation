<?php

namespace Bermuda\Validation\Rules;

use Generator;

final class OneOf implements RuleCollectionInterface, ValidationDataAwareInterface
{
    use RuleCollectionTrait, ValidationDataTrait;

    /**
     * @inheritDoc
     */
    public function validate($value): bool|string|array
    {
        if ($this->data === null) throw new NullValidationDataException;
        foreach ($this->rules as $rule) {
            if ($rule instanceof ValidationDataAwareInterface) $rule->setData($this->data);
            if (($result = $rule->validate($value)) === true) {
                return true;
            }
        }

        return $result;
    }
    
    public function getName(): string 
    {
        return 'oneOf';
    }
}
