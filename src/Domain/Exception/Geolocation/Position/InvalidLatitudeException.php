<?php

declare(strict_types=1);

namespace App\Domain\Exception\Geolocation\Position;

use App\Domain\Model\Geolocation\Position;

final class InvalidLatitudeException extends \Exception
{
    public static function for(float $latitude): self
    {
        return new self(sprintf(
            'Latitude %s is not valid. It should be between %d and %d',
            $latitude,
            Position::LATITUDE_MIN,
            Position::LATITUDE_MAX
        ));
    }
}
