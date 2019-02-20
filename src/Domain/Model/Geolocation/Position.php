<?php

declare(strict_types=1);

namespace App\Domain\Model\Geolocation;

use App\Domain\Exception\Geolocation\Position\InvalidLatitudeException;
use App\Domain\Exception\Geolocation\Position\InvalidLongitudeException;

final class Position
{
    private $latitude;
    private $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->checkLatitude($latitude);
        $this->checkLongitude($longitude);

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->latitude;
    }

    private function checkLatitude(float $latitude): void
    {
        if ($latitude < -90 || $latitude > 90) {
            throw InvalidLatitudeException::for($latitude);
        }
    }

    private function checkLongitude(float $longitude): void
    {
        if ($longitude < -180 || $longitude > 180) {
            throw InvalidLongitudeException::for($longitude);
        }
    }
}
