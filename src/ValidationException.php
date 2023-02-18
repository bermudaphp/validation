<?php

namespace Bermuda\Validation;

class ValidationException extends \RuntimeException
{
    public function __construct(protected array $errors, protected array $data, public readonly ?Validator $validator = null, int $deep = null)
    {
        if ($deep !== null) {
            $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $deep)[$deep - 1];
            $this->file = $stack['file'];
            $this->line = $stack['line'];
        }

        parent::__construct('Validation failed. Number of errors:: ' .count($errors), 422);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getErrorsAsJson(string $key = 'errors'): string
    {
        return json_encode([$key => $this->errors]);
    }

    /**
     * @return array
     */
    public function getValidationData(): array
    {
        return $this->data;
    }
}
