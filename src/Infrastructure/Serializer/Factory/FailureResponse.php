<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Factory;

use App\Infrastructure\Serializer\Factory;
use App\Infrastructure\Serializer\Proxy;
use App\Infrastructure\Symfony\Response\FailureResponse as FailureResponseDTO;

class FailureResponse extends Factory
{
    public function __construct()
    {
        parent::__construct(
            FailureResponseDTO::class,
            Proxy\FailureResponse::class
        );
    }
}
