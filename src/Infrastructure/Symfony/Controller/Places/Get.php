<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Places;

use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Finder;
use App\Infrastructure\Symfony\Response\Success\OKResponse;
use Ramsey\Uuid\Uuid;
use App\Domain\Exception\Finder\Place\PlaceNotFoundException;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;

final class Get
{
    private $placeFinder;

    public function __construct(Finder\Place $placeFinder)
    {
        $this->placeFinder = $placeFinder;
    }

    /**
     * @Route("/places/{placeId}", name="places_get", methods={"GET"})
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
