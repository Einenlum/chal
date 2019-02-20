<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Geolocation\Position;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use App\Domain\Model\Geolocation\Position;
use App\Domain\Exception\Geolocation\Position\InvalidLatitudeException;

final class ValidLatitudeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        try {
            Position::checkLatitude((float) $value);
        } catch (InvalidLatitudeException $exception) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ min_value }}', (string) Position::LATITUDE_MIN)
                ->setParameter('{{ max_value }}', (string) Position::LATITUDE_MAX)
                ->addViolation()
            ;
        }
    }
}
