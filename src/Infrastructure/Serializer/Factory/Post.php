<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Factory;

use App\Domain\Model;
use App\Infrastructure\Serializer\Proxy;
use App\Infrastructure\Serializer\Factory;

class Post extends Factory
{
    public function __construct()
    {
        parent::__construct(
            Model\Post::class,
            Proxy\Post::class
        );
    }
}
