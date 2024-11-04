<?php

namespace WolfShop\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected array $handlers = [
        ValidationException::class => 'handleValidation',
        ModelNotFoundException::class => 'handleModelNotFound',
        AuthenticationException::class => 'handleAuthentication',
    ];

    public function render($request, Throwable $e): Response
    {
        $className = get_class($e);

        if (array_key_exists($className, $this->handlers)) {
            $method = $this->handlers[$className];

            return response()->json([
                'errors' => $this->{$method}($e)
            ], $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'errors' => [
                [
                    'type' => basename($className),
                    'status' => $this->isHttpException($e) ? $e->getStatusCode() : 0,
                    'message' => $e->getMessage(),
                    'source' => '',
                ]
            ]
        ], $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function handleValidation(ValidationException $e): array
    {
        $errors = [];

        foreach ($e->errors() as $key => $message) {
            $errors[] = [
                'type' => basename(ValidationException::class),
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $message,
                'source' => $key,
            ];
        }

        return $errors;
    }

    private function handleModelNotFound(ModelNotFoundException $e): array
    {
        return [
            [
                'type' => basename(ModelNotFoundException::class),
                'status' => Response::HTTP_NOT_FOUND,
                'message' => $e->getMessage(),
                'source' => $e->getModel(),
            ]
        ];
    }

    private function handleAuthentication(AuthenticationException $e): array
    {
        return [
            [
                'type' => basename(AuthenticationException::class),
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthenticated.',
                'source' => '',
            ]
        ];
    }
}
