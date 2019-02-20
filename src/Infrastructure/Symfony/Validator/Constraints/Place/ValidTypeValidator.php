<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Place;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use App\Domain\Model\Place;

final class ValidTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (in_array($value, Place::VALID_TYPES)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->setParameter('{{ valid_types }}',
                join(', ', array_map(function ($type) {
                    return sprintf("'%s'", $type);
                }, Place::VALID_TYPES))
            )
            ->addViolation()
        ;
    }
}
