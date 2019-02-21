<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response;

abstract class FailureResponse
{
    private $type;
    private $title;

    public function __construct(string $type, string $title)
    {
        $this->type = $type;
        $this->title = $title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
