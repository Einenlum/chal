<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Domain\Repository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Ramsey\Uuid\Uuid;
use App\Infrastructure\Symfony\Request\Annotations\InjectDTO;
use App\Application\DTO\Event\Create as CreateDTO;
use App\Application\Factory\Event\Creation;
use App\Domain\Exception\Finder\Place\PlaceNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Infrastructure\Symfony\Response\Success\CreatedResponse;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;

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
