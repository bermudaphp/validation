<?php

namespace Bermuda\Validation;

class ValidationException extends \RuntimeException
{
    public function __construct(
        public readonly array $errors, 
        public readonly array $data, 
        public readonly ?Validator $validator = null
    ) {
        $this->file = ($stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $deep)[2])['file'];
        $this->line = $stack['line'];

        parent::__construct('Validation failed. Number of errors:: ' .count($errors), 422);
    }

    /**
     * @param string $key
     * @return string
     */
    public function getErrorsAsJson(string $key = 'errors'): string
    {
        return json_encode([$key => $this->errors]);
    }
}
