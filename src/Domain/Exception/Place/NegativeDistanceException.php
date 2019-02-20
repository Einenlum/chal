<?php

declare(strict_types=1);

namespace App\Domain\Exception\Place;

final class NegativeDistanceException extends \Exception
{
    public static function create(): self
    {
        return new self('Distance value cannot be negative.');
    }
}
