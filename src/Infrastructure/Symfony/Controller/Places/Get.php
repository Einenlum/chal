<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Places;

use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Finder;
use App\Infrastructure\Symfony\Response\Success\OKResponse;
use Ramsey\Uuid\Uuid;
use App\Domain\Exception\Finder\Place\PlaceNotFoundException;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;
use Swagger\Annotations as SWG;

final class Get
{
    private $placeFinder;

    public function __construct(Finder\Place $placeFinder)
    {
        $this->placeFinder = $placeFinder;
    }

    /**
     * @Route("/places/{placeId}", name="places_get", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="The representation of the place"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Place not found"
     * )
     * @SWG\Parameter(
     *     name="placeId",
     *     in="path",
     *     type="string",
     *     format="uuid",
     *     required=true
     * )
     * @SWG\Tag(name="places")
     */
    public function __invoke(Uuid $placeId)
    {
        try {
            $place = $this->placeFinder->get($placeId);
        } catch (PlaceNotFoundException $e) {
            return NotFoundResponse::withTitle('Place could not be found.');
        }

        return OKResponse::createFor($place);
    }
}
