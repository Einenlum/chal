<?php

declare(strict_types=1);

namespace App\Application\Factory\Event;

use App\Application\DTO\Event\Create as CreateDTO;
use App\Domain\Finder;
use App\Domain\Model;
use App\Domain\Model\Time\Period;

final class Creation
{
    private $placeFinder;

    public function __construct(Finder\Place $placeFinder)
    {
        $this->placeFinder = $placeFinder;
    }

    public function createEvent(CreateDTO $dto): Model\Event
    {
        $place = $this->placeFinder->get($dto->placeId);
        $period = new Period($dto->periodStart, $dto->periodEnd);

        return new Model\Event($place, $period, $dto->name, $dto->type);
    }
}
