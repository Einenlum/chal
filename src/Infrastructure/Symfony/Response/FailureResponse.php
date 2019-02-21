<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response;

abstract class FailureResponse
{
    private $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
