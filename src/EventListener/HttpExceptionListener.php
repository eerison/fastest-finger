<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

#[AsEventListener]
class HttpExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (false === $exception instanceof HttpExceptionInterface) {
            return;
        }

        if ($exception instanceof BadRequestHttpException) {
            $response = new JsonResponse([
                'data' => [
                    'message' => $exception->getMessage(),
                    'code' => JsonResponse::HTTP_BAD_REQUEST,
                ],
            ], JsonResponse::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        }

        if ($exception instanceof UnprocessableEntityHttpException) {
            $exception = $exception->getPrevious();
            $response = new JsonResponse([
                'data' => [
                    'message' => $exception->getMessage(),
                    'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                ],
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

            $event->setResponse($response);
        }
    }
}
