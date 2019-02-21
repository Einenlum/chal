<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Success;

use App\Infrastructure\Symfony\Response\SuccessResponse;

final class CreatedResponse extends SuccessResponse
{
    private $locationPath;

    public static function createFor(object $value, string $locationPath): self
    {
        $response = new self($value);
        $response->locationPath = $locationPath;

        return $response;
    }

    public function getLocationPath(): string
    {
        return $this->locationPath;
    }
}
