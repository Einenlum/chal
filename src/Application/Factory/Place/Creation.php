<?php

declare(strict_types=1);

namespace App\Application\Factory\Place;

use App\Application\DTO\Place\Create as CreateDTO;
use App\Domain\Model\Geolocation\Position;
use App\Domain\Model\Place;

final class Creation
{
    public function createPlace(CreateDTO $dto): Place
    {
        $position = new Position($dto->latitude, $dto->longitude);

        return new Place($dto->name, $position, $dto->type);
    }
}
