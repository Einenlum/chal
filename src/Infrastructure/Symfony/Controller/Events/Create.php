<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Application\DTO\Event\Create as CreateDTO;
use App\Application\Factory\Event\Creation;
use App\Domain\Exception\Finder\Place\PlaceNotFoundException;
use App\Domain\Repository;
use App\Infrastructure\Symfony\Request\Annotations\InjectDTO;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;
use App\Infrastructure\Symfony\Response\Success\CreatedResponse;
use Ramsey\Uuid\Uuid;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class Create
{
    private $eventRepository;
    private $createEventFactory;
    private $urlGenerator;

    public function __construct(
        Repository\Event $eventRepository,
        Creation $createEventFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->eventRepository = $eventRepository;
        $this->createEventFactory = $createEventFactory;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route(
     *     "/places/{placeId}/events",
     *     name="events_create",
     *     methods={"POST"},
     *     requirements={"placeId"="%uuid_regex%"}
     * )
     * @InjectDTO(class="App\Application\DTO\Event\Create", mapping={
     *     "placeId": "placeId"
     * })
     * @SWG\Response(
     *     response=201,
     *     description="The event was successfully created"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Invalid arguments"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="The place does not exist"
     * )
     * @SWG\Parameter(
     *     name="placeId",
     *     in="path",
     *     type="string",
     *     format="uuid",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="parameters",
     *     in="body",
     *     schema={
     *         "type"="object",
     *         "required"={
     *             "periodStart",
     *             "periodEnd",
     *             "name",
     *             "type"
     *         },
     *         "properties"={
     *             "name"={
     *                 "type"="string"
     *             },
     *             "type"={
     *                 "type"="string",
     *                 "example"="A valid type"
     *             },
     *             "periodStart"={
     *                 "type"="string",
     *                 "format"="date-time",
     *                 "example"="2017-07-21T17:32:28Z"
     *             },
     *             "periodEnd"={
     *                 "type"="string",
     *                 "format"="date-time",
     *                 "example"="2017-09-21T17:32:28Z"
     *             }
     *         }
     *     }
     * )
     * @SWG\Tag(name="events")
     */
    public function __invoke(CreateDTO $dto)
    {
        try {
            $event = $this->createEventFactory->createEvent($dto);
        } catch (PlaceNotFoundException $e) {
            return NotFoundResponse::withTitle(
                sprintf('No place found with id %s', (string) $dto->placeId)
            );
        }

        $this->eventRepository->add($event);

        return CreatedResponse::createFor(
            $event,
            $this->urlGenerator->generate('events_get', [
                'eventId' => (string) $event->getId(),
            ])
        );
    }
}
