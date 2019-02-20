<?php

declare(strict_types=1);

namespace App\Domain\Exception\Place\Position;

final class InvalidLatitudeException extends \Exception
{
    public static function for(float $latitude): self
    {
        return new self(sprintf(
            'Latitude %s is not valid. It should be between -90 and 90',
            $latitude
        ));
    }
}
