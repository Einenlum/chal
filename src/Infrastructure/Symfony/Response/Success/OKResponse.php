<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Success;

use App\Infrastructure\Symfony\Response\SuccessResponse;

final class OKResponse extends SuccessResponse
{
    public static function createFor($value = null): self
    {
        return new self($value);
    }
}
