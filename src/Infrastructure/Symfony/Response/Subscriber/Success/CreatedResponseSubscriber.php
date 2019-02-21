<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Subscriber\Success;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use App\Infrastructure\Symfony\Response\Success\CreatedResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Serializer\JsonSerializer;
use App\Infrastructure\Symfony\Response\Http\JsonResponse;

final class CreatedResponseSubscriber implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(JsonSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function sendResponse(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!is_object($result) || !$result instanceof CreatedResponse) {
            return;
        }

        $httpResponse = new JsonResponse(
            $this->serializer->serialize($result->getValue()->getId()),
            Response::HTTP_CREATED,
            ['location' => $result->getLocationPath()]
        );
        $event->setResponse($httpResponse);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => ['sendResponse']];
    }
}
