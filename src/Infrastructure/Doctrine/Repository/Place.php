<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Exception\Finder\Place\PlaceNotFoundException;
use App\Domain\Finder;
use App\Domain\Model;
use App\Domain\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class Place extends ServiceEntityRepository implements Finder\Place, Repository\Place
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Model\Place::class);
    }

    /**
     * {@inheritdoc}
     */
    public function get(Uuid $placeId): Model\Place
    {
        if (null === $place = $this->find($placeId)) {
            throw PlaceNotFoundException::for($placeId);
        }

        return $place;
    }

    public function add(Model\Place $place): void
    {
        $this->_em->persist($place);
        $this->_em->flush();
    }
}
