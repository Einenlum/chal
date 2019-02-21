<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response;

abstract class SuccessResponse
{
    private $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
