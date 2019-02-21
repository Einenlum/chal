<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Exception\Finder\Event\EventNotFoundException;
use App\Domain\Finder;
use App\Domain\Model;
use App\Domain\Model\Geolocation\Distance\Meters;
use App\Domain\Model\Geolocation\Position;
use App\Domain\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class Event extends ServiceEntityRepository implements Finder\Event, Repository\Event
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

    public function get(Uuid $eventId): Model\Event
    {
        if (null === $event = $this->find($eventId)) {
            throw EventNotFoundException::for($eventId);
        }

        return $event;
    }

    public function getAllCloseTo(Position $position, Meters $maxDistance): array
    {
        return $this->findAll();

        /*
         * This should have been working… Sad story! :'(
         *
        $qb
            ->join('e.place', 'place')
            ->where('stdistancesphere(place.position, :position) <= :maxDistance')
            ->setParameter('position', $point)
            ->setParameter('maxDistance', $maxDistance->getValue())
            ->getQuery()
            ->getResult()
        ;
         */
    }
}
