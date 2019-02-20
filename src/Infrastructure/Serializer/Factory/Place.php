<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Factory;

use App\Domain\Model;
use App\Infrastructure\Serializer\Proxy;
use App\Infrastructure\Serializer\Factory;

class Place extends Factory
{
    public function __construct()
    {
        parent::__construct(
            Model\Place::class,
            Proxy\Place::class
        );
    }
}
