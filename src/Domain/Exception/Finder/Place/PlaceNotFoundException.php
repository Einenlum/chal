<?php

declare(strict_types=1);

namespace App\Domain\Exception\Finder\Place;

use Ramsey\Uuid\Uuid;

final class PlaceNotFoundException extends \Exception
{
    public static function for(Uuid $placeId): self
    {
        $message = sprintf('No place was found with id %s', (string) $placeId);

        return new self($message);
    }
}
