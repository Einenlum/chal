<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Failure;

use App\Infrastructure\Symfony\Response\FailureResponse;

final class BadRequestResponse extends FailureResponse
{
    public static function createWithErrors(array $errors = [])
    {
        return new self($errors);
    }
}
