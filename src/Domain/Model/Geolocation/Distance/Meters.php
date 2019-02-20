<?php

declare(strict_types=1);

namespace App\Domain\Model\Geolocation\Distance;

final class Meters
{
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }
}
