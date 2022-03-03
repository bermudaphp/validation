<?php

namespace Bermuda\ErrorHandler;

use Throwable;
use Bermuda\Validation\ValidationException;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

final class ValidationErrorResponseGenerator implements ErrorResponseGeneratorInterface, ResponseFactoryAwareInterface
{
    public function canGenerate(Throwable $e, ServerRequestInterface $request = null): bool
    {
        return $e instanceof ValidationException;
    }

    /**
     * @param Throwable $e
     * @param ServerRequestInterface|null $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function generateResponse(Throwable $e, ServerRequestInterface $request = null): ResponseInterface
    {
        if (!$this->canGenerate($e)) {
            throw $e;
        }

        /**
         * @var ValidationException $e;
         */
        $response = $this->responseFactory->createResponse(400);
        $response->getBody()->write(json_encode($e->getErrors()));

        return $response;
    }
}
