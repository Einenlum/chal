<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer\Proxy;

use App\Infrastructure\Symfony\Response\FailureResponse as FailureResponseDTO;

final class FailureResponse
{
    public $type;
    public $title;
    public $details = [];

    public function __construct(FailureResponseDTO $failureResponse)
    {
        $this->type = $failureResponse->getType();
        $this->title = $failureResponse->getTitle();
        $this->details = $failureResponse->getDetails();
    }
}
