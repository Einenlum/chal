<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Failure;

use App\Infrastructure\Symfony\Response\FailureResponse;

final class NotFoundResponse extends FailureResponse
{
    const TYPE = 'Not Found';

    public static function withTitle(string $title)
    {
        return new self(self::TYPE, $title);
    }
}
