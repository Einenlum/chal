<?php

declare(strict_types=1);

namespace App\Domain\Model\Geolocation\Distance;

use App\Domain\Exception\Place\NegativeDistanceException;

final class Meters
{
    private $value;

    public function __construct(float $value)
    {
        if ($value < 0) {
            throw NegativeDistanceException::create();
        }

        $this->value = $value;
    }
}
