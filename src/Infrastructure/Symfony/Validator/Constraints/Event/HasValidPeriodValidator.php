<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Event;

use App\Domain\Exception\Time\InvalidPeriodException;
use App\Domain\Model\Time\Period;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class HasValidPeriodValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $validPeriod = is_object($value->periodStart)
            && $value->periodStart instanceof \DateTimeImmutable
            && is_object($value->periodEnd)
            && $value->periodEnd instanceof \DateTimeImmutable
        ;

        if ($validPeriod) {
            try {
                new Period($value->periodStart, $value->periodEnd);
            } catch (InvalidPeriodException $exception) {
                $validPeriod = false;
            }
        }

        if ($validPeriod) {
            return;
        }

        $this
            ->context
            ->buildViolation($constraint->message)
            ->atPath('periodStart')
            ->addViolation()
        ;
    }
}
