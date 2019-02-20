<?php

declare(strict_types=1);

namespace App\Domain\Model\Geolocation;

use App\Domain\Exception\Geolocation\Position\InvalidLatitudeException;
use App\Domain\Exception\Geolocation\Position\InvalidLongitudeException;

final class Position
{
    const LATITUDE_MIN = -90.;
    const LATITUDE_MAX = 90.;
    const LONGITUDE_MIN = -180.;
    const LONGITUDE_MAX = 180.;

    private $latitude;
    private $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        self::checkLatitude($latitude);
        self::checkLongitude($longitude);

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

    public static function checkLatitude(float $latitude): void
    {
        if ($latitude < self::LATITUDE_MIN || $latitude > self::LATITUDE_MAX) {
            throw InvalidLatitudeException::for($latitude);
        }
    }

    public static function checkLongitude(float $longitude): void
    {
        if ($longitude < self::LONGITUDE_MIN || $longitude > self::LONGITUDE_MAX) {
            throw InvalidLongitudeException::for($longitude);
        }
    }
}
