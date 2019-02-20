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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Create
{
    private $serializer;
    private $eventRepository;
    private $createEventFactory;

    public function __construct(
        SerializerInterface $serializer,
        Repository\Event $eventRepository,
        Creation $createEventFactory
    ) {
        $this->serializer = $serializer;
        $this->eventRepository = $eventRepository;
        $this->createEventFactory = $createEventFactory;
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
            throw new NotFoundHttpException();
        }

        $this->eventRepository->add($event);

        return new Response($this->serializer->serialize($event, 'json'), 201);
    }
}
