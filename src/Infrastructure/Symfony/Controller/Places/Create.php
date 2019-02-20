<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Places;

use Symfony\Component\Routing\Annotation\Route;
use App\Application\DTO\Place\Create as CreateDTO;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Factory\Place\Creation;
use App\Domain\Repository;
use App\Infrastructure\Symfony\Request\Annotations\InjectDTO;

final class Create
{
    private $serializer;
    private $placeCreationFactory;
    private $placeRepository;

    public function __construct(
        SerializerInterface $serializer,
        Creation $placeCreationFactory,
        Repository\Place $placeRepository
    ) {
        $this->serializer = $serializer;
        $this->placeCreationFactory = $placeCreationFactory;
        $this->placeRepository = $placeRepository;
    }

    /**
     * @Route("/places", name="places_create", methods={"POST"})
     * @InjectDTO(class="App\Application\DTO\Place\Create")
     */
    public function __invoke(CreateDTO $dto)
    {
        $place = $this->placeCreationFactory->createPlace($dto);
        $this->placeRepository->add($place);

        return new Response($this->serializer->serialize($place, 'json'));
    }
}
