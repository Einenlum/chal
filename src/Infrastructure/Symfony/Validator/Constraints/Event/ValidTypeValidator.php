<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Event;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use App\Domain\Model\Event;

final class ValidTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (in_array($value, Event::VALID_TYPES)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->setParameter('{{ valid_types }}',
                join(', ', array_map(function ($type) {
                    return sprintf("'%s'", $type);
                }, Event::VALID_TYPES))
            )
            ->addViolation()
        ;
    }
}
