<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidatorException;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (
            $exception instanceof ValidatorException
            || $exception instanceof BadRequestHttpException
        ) {
            $message = json_encode([
                'code' => 400,
                'msg' => $exception->getMessage(),
            ]);

            $response = new Response();
            $response->setContent($message);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->headers->set('Content-Type', 'application/json');

            // sends the modified response object to the event
            $event->setResponse($response);
        }

        if ($exception instanceof UnprocessableEntityHttpException) {
            $message = json_encode([
                'code' => 422,
                'msg' => $exception->getMessage(),
            ]);

            $response = new Response();
            $response->setContent($message);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            $response->headers->set('Content-Type', 'application/json');

            // sends the modified response object to the event
            $event->setResponse($response);
        }

        if (
            $exception instanceof NotFoundHttpException
            || $exception instanceof MethodNotAllowedHttpException
        ) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $event->setResponse($response);
        }
    }
}
