<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Subscriber\Failure;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Serializer\JsonSerializer;
use App\Infrastructure\Symfony\Response\Http\JsonResponse;
use App\Infrastructure\Symfony\Response\Failure\BadRequestResponse;

final class BadRequestResponseSubscriber implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(JsonSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function sendResponse(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!is_object($result) || !$result instanceof BadRequestResponse) {
            return;
        }

        $httpResponse = new JsonResponse(
            $this->serializer->serialize($result->getErrors()),
            Response::HTTP_BAD_REQUEST,
            []
        );
        $event->setResponse($httpResponse);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => ['sendResponse']];
    }
}
