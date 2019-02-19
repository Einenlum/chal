<?php

declare(strict_types=1);

namespace App\Domain\Exception;

final class InvalidPeriodException extends \Exception
{
    public static function create(): self
    {
        return new self('The start period must be before the end period');
    }
}
