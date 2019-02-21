<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Factory;

use App\Domain\Model;
use App\Infrastructure\Serializer\Factory;
use App\Infrastructure\Serializer\Proxy;

class Event extends Factory
{
    public function __construct()
    {
        parent::__construct(
            Model\Event::class,
            Proxy\Event::class
        );
    }
}
