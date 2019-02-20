<?php

declare(strict_types=1);

namespace App\Domain\Finder;

use App\Domain\Model;
use Ramsey\Uuid\Uuid;

interface Place
{
    /**
     * @Throws App\Domain\Exception\Finder\Place\PlaceNotFoundException
     */
    public function get(Uuid $placeId): Model\Place;
}
