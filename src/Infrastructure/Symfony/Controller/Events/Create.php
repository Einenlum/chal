<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Domain\Repository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

final class Create
{
    private $serializer;
    private $eventRepository;

    public function __construct(
        SerializerInterface $serializer,
        Repository\Event $eventRepository
    ) {
        $this->serializer = $serializer;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @Route(
     *     "/places/{placeId}/events",
     *     name="events_create",
     *     methods={"POST"},
     *     requirements={"placeId"="%uuid_regex%"}
     * )
     */
    public function __invoke()
    {
    }
}
