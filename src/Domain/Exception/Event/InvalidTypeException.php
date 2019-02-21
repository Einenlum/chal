<?php

declare(strict_types=1);

namespace App\Domain\Exception\Event;

use App\Domain\Model\Event;

final class InvalidTypeException extends \Exception
{
    public static function triedWith($value): self
    {
        return new self(sprintf(
            'The type %s is not valid. Valid types are %s',
            $value,
            join(', ', array_map(function ($type) {
                return sprintf("'%s'", $type);
            }, Event::VALID_TYPES))
        ));
    }
}
