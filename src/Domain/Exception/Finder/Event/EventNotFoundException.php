<?php

declare(strict_types=1);

namespace App\Domain\Exception\Finder\Event;

use Ramsey\Uuid\Uuid;

final class EventNotFoundException extends \Exception
{
    public static function for(Uuid $eventId): self
    {
        $message = sprintf('No event was found with id %s', (string) $eventId);

        return new self($message);
    }
}
