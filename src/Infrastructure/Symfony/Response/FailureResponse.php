<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response;

abstract class FailureResponse
{
    private $type;
    private $title;
    private $details;

    public function __construct(string $type, string $title, array $details = [])
    {
        $this->type = $type;
        $this->title = $title;
        $this->details = $details;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}
