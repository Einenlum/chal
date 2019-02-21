<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Failure;

use App\Infrastructure\Symfony\Response\FailureResponse;

final class InternalServerErrorResponse extends FailureResponse
{
    const TYPE = 'Internal Server Error';

    public static function create()
    {
        return new self(self::TYPE, '');
    }
}
