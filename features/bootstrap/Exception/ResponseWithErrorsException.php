<?php

declare(strict_types=1);

namespace Test\Exception;

class ResponseWithErrorsException extends \Exception
{
    public static function withErrors(array $errors): self
    {
        $message = sprintf('Errors: %s', implode(' | ', $errors));

        return new self($message);
    }
}
