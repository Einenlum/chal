<?php

declare(strict_types=1);

namespace Test\Exception;

class ValidResponseException extends \Exception
{
    public static function withValue($value): self
    {
        $value = json_encode($value);
        $message = sprintf('Value (instead of errors): %s', $value);

        return new self($message);
    }
}
