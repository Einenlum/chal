<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Failure;

use App\Infrastructure\Symfony\Response\FailureResponse;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class BadRequestResponse extends FailureResponse
{
    const TYPE = 'Bad Request';

    public static function createWithErrors(array $errors = []): self
    {
        $title = implode(', ', $errors);

        return new self(self::TYPE, $title);
    }

    public static function fromViolationList(ConstraintViolationListInterface $violationList): self
    {
        $errors = [];
        foreach ($violationList as $violation) {
            $errors[] = sprintf('%s: %s', $violation->getPropertyPath(), $violation->getMessage());
        }

        return self::createWithErrors($errors);
    }
}
