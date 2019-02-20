<?php

declare(strict_types=1);

namespace App\Domain\Exception\Place\Position;

final class InvalidLongitudeException extends \Exception
{
    public static function for(float $longitude): self
    {
        return new self(sprintf(
            'Longitude %s is not valid. It should be between -180 and 180',
            $longitude
        ));
    }
}
