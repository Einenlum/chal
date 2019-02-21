<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Failure;

use App\Infrastructure\Symfony\Response\FailureResponse;

final class CustomResponse extends FailureResponse
{
    public static function createWithTypeAndTitle(string $type, string $title, array $details = []): self
    {
        return new self($type, $title, $details);
    }
}
