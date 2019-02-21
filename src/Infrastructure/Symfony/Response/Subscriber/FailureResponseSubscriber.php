<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use App\Infrastructure\Serializer\JsonSerializer;
use App\Infrastructure\Symfony\Response\Http\JsonResponse;
use App\Infrastructure\Symfony\Response\FailureResponse;
use App\Infrastructure\Symfony\Response\Failure\InternalServerErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Symfony\Response\Failure\BadRequestResponse;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;

final class FailureResponseSubscriber implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(JsonSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function sendResponse(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!is_object($result) || !$result instanceof FailureResponse) {
            return;
        }

        $httpResponse = new JsonResponse(
            $this->serializer->serialize($result),
            $this->getStatusCode($result)
        );
        $event->setResponse($httpResponse);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => ['sendResponse']];
    }

    private function getStatusCode(FailureResponse $response)
    {
        if ($response instanceof BadRequestResponse) {
            return Response::HTTP_BAD_REQUEST;
        }

        if ($response instanceof NotFoundResponse) {
            return Response::HTTP_NOT_FOUND;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
