<?php

namespace Bermuda\Validation;

class ValidationException extends \RuntimeException
{
    public function __construct(
        public readonly array $errors,
        public readonly array $data,
        public readonly ValidatorInterface $validator,
        public string $file, public int $line
    )
    {
        $this->file = $file;
        $this->line = $line;

        parent::__construct(
            sprintf('Validation failed with %s %s', $c = count($errors), $c > 1 ? 'errors' : 'error'), 
            422
        );
    }

    /**
     * Return errors array as json string
     * @param string $key
     * @return string
     * @throws \JsonException
     */
    public function toJson(string $key = 'errors'): string
    {
        return json_encode([$key = $this->errors], JSON_THROW_ON_ERROR);
    }
}
