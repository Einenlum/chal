<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Events;

use App\Application\DTO\Event\GetAllAround as GetAllAroundDTO;
use App\Domain\Finder;
use App\Domain\Model\Geolocation\Distance\Meters;
use App\Domain\Model\Geolocation\Position;
use App\Infrastructure\Symfony\Response\Failure\BadRequestResponse;
use App\Infrastructure\Symfony\Response\Success\OKResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @SWG\Response(
     *     response=200,
     *     description="The list of all events (should be relative to the location but unfortunately not, cf. the readme)"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Invalid arguments"
     * )
     * @SWG\Parameter(
     *     name="latitude",
     *     in="query",
     *     type="number",
     *     format="float",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="longitude",
     *     in="query",
     *     type="number",
     *     format="float",
     *     required=true
     * )
     * @SWG\Parameter(
     *     name="meters",
     *     in="query",
     *     type="number",
     *     format="float",
     *     required=true
     * )
     * @SWG\Tag(name="events")
     */
    public function __invoke(Request $request)
    {
        $queryParameters = array_map(function ($item) {
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
