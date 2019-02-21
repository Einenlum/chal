<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * This subscriber checks if there are some uuid string in the
 * Request attributes and if so transforms them to real Uuid objects
 */
final class TransformUuids implements EventSubscriberInterface
{
    const PRIORITY = 30;
    const UUID_LENGTH = 36;

    public function transformUuids(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $attributes = $request->attributes->all();

        foreach ($attributes as $key => $value) {
            if (!is_string($value)) {
                continue;
            }

            if (strlen($value) !== self::UUID_LENGTH) {
                continue;
            }

            try {
                $value = Uuid::fromString($value);
                $request->attributes->set($key, $value);
            } catch (InvalidUuidStringException $e) {
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => ['transformUuids', self::PRIORITY]];
    }
}
