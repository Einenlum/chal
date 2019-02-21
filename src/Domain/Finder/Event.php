<?php

declare(strict_types=1);

namespace App\Domain\Finder;

use App\Domain\Model;
use App\Domain\Model\Geolocation\Distance\Meters;
use App\Domain\Model\Geolocation\Position;
use Ramsey\Uuid\Uuid;

interface Event
{
    public function get(Uuid $eventId): Model\Event;

    public function getAllCloseTo(Position $position, Meters $maxDistance): array;
}
