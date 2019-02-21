<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

final class JsonSerializer
{
    const JSON_TYPE = 'json';

    private $symfonySerializer;

    public function __construct(SerializerInterface $symfonySerializer)
    {
        $this->symfonySerializer = $symfonySerializer;
    }

    public function serialize($data = null)
    {
        return $this->symfonySerializer->serialize($data, self::JSON_TYPE);
    }
}
