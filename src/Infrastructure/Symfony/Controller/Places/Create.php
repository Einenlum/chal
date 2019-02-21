<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Places;

use Symfony\Component\Routing\Annotation\Route;
use App\Application\DTO\Place\Create as CreateDTO;
use App\Application\Factory\Place\Creation;
use App\Domain\Repository;
use App\Infrastructure\Symfony\Request\Annotations\InjectDTO;
use App\Infrastructure\Symfony\Response\Success\CreatedResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class Create
{
    private $placeCreationFactory;
    private $placeRepository;
    private $urlGenerator;

    public function __construct(
        Creation $placeCreationFactory,
        Repository\Place $placeRepository,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->placeCreationFactory = $placeCreationFactory;
        $this->placeRepository = $placeRepository;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/places", name="places_create", methods={"POST"})
     * @InjectDTO(class="App\Application\DTO\Place\Create")
     */
    public function __invoke(CreateDTO $dto)
    {
        $place = $this->placeCreationFactory->createPlace($dto);
        $this->placeRepository->add($place);

        return CreatedResponse::createFor(
            $place,
            $this->urlGenerator->generate('places_get', [
                'placeId' => (string) $place->getId(),
            ])
        );
    }
}
