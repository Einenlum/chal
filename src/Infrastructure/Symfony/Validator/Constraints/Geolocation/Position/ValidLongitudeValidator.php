<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Geolocation\Position;

use App\Domain\Exception\Geolocation\Position\InvalidLongitudeException;
use App\Domain\Model\Geolocation\Position;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class ValidLongitudeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        try {
            Position::checkLongitude((float) $value);
        } catch (InvalidLongitudeException $exception) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ min_value }}', (string) Position::LONGITUDE_MIN)
                ->setParameter('{{ max_value }}', (string) Position::LONGITUDE_MAX)
                ->addViolation()
            ;
        }
    }
}
