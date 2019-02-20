<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Domain\Model;
use App\Domain\Repository;

final class Event extends ServiceEntityRepository implements Repository\Event
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Model\Event::class);
    }

    public function add(Model\Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush();
    }
}
