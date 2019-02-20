<?php

declare(strict_types=1);

namespace App\Domain\Model\Geolocation;

final class Distance
{
    const UNIT_METERS = 'meters';

    private $type;

    private $value;

    private function __construct(string $type, float $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public static function meters(float $value): self
    {
        return new self(self::UNIT_METERS, $value);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
