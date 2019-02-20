<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Places;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\DTO\Place\Create as CreateDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Factory\Place\Creation;
use App\Domain\Repository;

final class Create
{
    private $validator;
    private $serializer;
    private $placeCreationFactory;
    private $placeRepository;

    public function __construct(
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Creation $placeCreationFactory,
        Repository\Place $placeRepository
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->placeCreationFactory = $placeCreationFactory;
        $this->placeRepository = $placeRepository;
    }

    /**
     * @Route("/places", name="places_create", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $data = json_decode((string) $request->getContent(), true);
        $dto = CreateDTO::fromArray($data);

        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            return new Response($this->serializer->serialize($errors, 'json'), 400);
        }

        $place = $this->placeCreationFactory->createPlace($dto);
        $this->placeRepository->add($place);

        return new Response($this->serializer->serialize($place, 'json'));
    }
}
