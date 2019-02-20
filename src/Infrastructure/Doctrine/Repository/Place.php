<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Domain\Model;
use App\Domain\Repository;

final class Place extends ServiceEntityRepository implements Repository\Place
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Model\Place::class);
    }

    public function add(Model\Place $place): void
    {
        $this->_em->persist($place);
        $this->_em->flush();
    }
}
