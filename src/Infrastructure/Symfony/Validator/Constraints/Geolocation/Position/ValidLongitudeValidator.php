<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Geolocation\Position;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use App\Domain\Model\Geolocation\Position;
use App\Domain\Exception\Geolocation\Position\InvalidLongitudeException;

final class ValidLongitudeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        try {
            Position::checekLongitude($value);
        } catch (InvalidLongitudeException $exception) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ min_value }}', Position::LONGITUDE_MIN)
                ->setParameter('{{ max_value }}', Position::LONGITUDE_MAX)
                ->addViolation()
            ;
        }
    }
}
