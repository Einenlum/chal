<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Subscriber\Success;

use App\Infrastructure\Serializer\JsonSerializer;
use App\Infrastructure\Symfony\Response\Http\JsonResponse;
use App\Infrastructure\Symfony\Response\Success\OKResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class OKResponseSubscriber implements EventSubscriberInterface
{
    private $serializer;

    public function __construct(JsonSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function sendResponse(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if (!is_object($result) || !$result instanceof OKResponse) {
            return;
        }

        $httpResponse = new JsonResponse(
            $this->serializer->serialize($result->getValue()),
            Response::HTTP_OK
        );
        $event->setResponse($httpResponse);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => ['sendResponse']];
    }
}
