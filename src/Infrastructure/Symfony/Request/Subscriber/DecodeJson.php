<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * This subscriber takes the json content of the Request,
 * tries to decode it, and throws automatically a Bad Request Exception
 * if the json is malformed.
 *
 * The priority of ensures that it runs before the InjectDTOIfNeeded
 * subscriber.
 */
final class DecodeJson implements EventSubscriberInterface
{
    const PRIORITY = 20;

    public function decodeJson(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $jsonContent = $request->getContent();
        if ($jsonContent === '') {
            return;
        }

        try {
            $data = json_decode($jsonContent, true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new BadRequestHttpException();
        }

        $request->attributes->set('data', $data);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => ['decodeJson', self::PRIORITY]];
    }
}
