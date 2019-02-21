<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Http;

use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

final class JsonResponse extends BaseJsonResponse
{
    public function __construct($value, int $statusCode, array $headers = [])
    {
        parent::__construct(
            $value,
            $statusCode,
            $headers,
            true // It is always JSON already
        );
    }
}
