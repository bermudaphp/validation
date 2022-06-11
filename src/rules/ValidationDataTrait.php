<?php

namespace Bermuda\Validation;

trait ValidationDataTrait
{
    private ?array $data = null;
    public function setData(array $data): ValidationDataAwareInterface
    {
        $this->data = $data;
        return $this;
    }
}
