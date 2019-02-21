<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Domain\Exception\Finder\Event\EventNotFoundException;
use App\Domain\Finder;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;
use App\Infrastructure\Symfony\Response\Success\OKResponse;
use Ramsey\Uuid\Uuid;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

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
     * @SWG\Response(
     *     response=200,
     *     description="The details of the event"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="The event does not exist"
     * )
     * @SWG\Parameter(
     *     name="eventId",
     *     in="path",
     *     type="string",
     *     format="uuid",
     *     required=true
     * )
     * @SWG\Tag(name="events")
     */
    public function __invoke(Uuid $eventId)
    {
        try {
            $event = $this->eventFinder->get($eventId);
        } catch (EventNotFoundException $e) {
            return NotFoundResponse::withTitle(
                sprintf('No event was found with id %s', (string) $eventId)
            );
        }

        return OKResponse::createFor($event);
    }
}
