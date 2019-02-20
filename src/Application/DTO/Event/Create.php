<?php

declare(strict_types=1);

namespace App\Application\DTO\Event;

final class Create
{
    public $placeId;

    /** @var \DateTimeImmutable */
    public $periodStart;

    /** @var \DateTimeImmutable */
    public $periodEnd;

    public $name;

    public $type;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        foreach ($data as $key => $value) {
            $dto->$key = $value;
        }

        return $dto;
    }
}
