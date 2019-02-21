<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Domain\Finder;
use Symfony\Component\Routing\Annotation\Route;
use Ramsey\Uuid\Uuid;
use App\Domain\Exception\Finder\Event\EventNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Infrastructure\Symfony\Response\Success\OKResponse;

final class Get
{
    private $eventFinder;

    public function __construct(
        Finder\Event $eventFinder
    ) {
        $this->eventFinder = $eventFinder;
    }

    /**
     * @Route(
     *     "/events/{eventId}",
     *     name="events_get",
     *     methods={"GET"},
     *     requirements={"eventId"="%uuid_regex%"}
     * )
     */
    public function __invoke(Uuid $eventId)
    {
        try {
            $event = $this->eventFinder->get($eventId);
        } catch (EventNotFoundException $e) {
            throw new NotFoundHttpException();
        }

        return OKResponse::createFor($event);
    }
}
