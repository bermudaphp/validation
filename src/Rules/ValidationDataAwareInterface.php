<?php

namespace Bermuda\Validation\Rules;

interface ValidationDataAwareInterface
{
    public function setData(array $data): ValidationDataAwareInterface ;
}
