<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Geolocation\Position;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use App\Domain\Model\Geolocation\Position;

final class ValidLongitudeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value < Position::LATITUDE_MIN || $value > Position::LATITUDE_MAX) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ min_value }}', Position::LONGITUDE_MIN)
                ->setParameter('{{ max_value }}', Position::LONGITUDE_MAX)
                ->addViolation()
            ;
        }
    }
}
