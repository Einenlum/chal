<?php

declare(strict_types=1);

namespace App\Application\DTO\Place;

final class Create
{
    public $name;

    public $type;

    public $latitude;

    public $longitude;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        foreach ($data as $key => $value) {
            $dto->$key = $value;
        }

        return $dto;
    }
}
