<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Domain\Finder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Application\DTO\Event\GetAllAround as GetAllAroundDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Domain\Model\Geolocation\Position;
use App\Domain\Model\Geolocation\Distance\Meters;
use App\Infrastructure\Symfony\Response\Success\OKResponse;
use App\Infrastructure\Symfony\Response\Failure\BadRequestResponse;

final class GetAllAround
{
    private $validator;
    private $serializer;
    private $eventFinder;

    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Finder\Event $eventFinder
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->eventFinder = $eventFinder;
    }

    /**
     * @Route(
     *     "/events/around",
     *     name="events_get_around",
     *     methods={"GET"}
     * )
     */
    public function __invoke(Request $request)
    {
        $queryParameters = array_map(function($item) {
            return floatval($item);
        }, $request->query->all());

        $dto = $this
            ->serializer
            ->denormalize($queryParameters, GetAllAroundDTO::class)
        ;
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return BadRequestResponse::fromViolationList($errors);
        }

        $events = $this->eventFinder->getAllCloseTo(
            new Position($dto->latitude, $dto->longitude),
            new Meters($dto->meters)
        );

        return OKResponse::createFor($events);
    }
}
