<?php

declare(strict_types=1);

namespace App\Domain\Exception\Geolocation\Position;

use App\Domain\Model\Geolocation\Position;

final class InvalidLongitudeException extends \Exception
{
    public static function for(float $longitude): self
    {
        return new self(sprintf(
            'Longitude %s is not valid. It should be between %d and %d',
            $longitude,
            Position::LONGITUDE_MIN,
            Position::LONGITUDE_MAX
        ));
    }
}
