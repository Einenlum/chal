<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Event;

use Symfony\Component\Validator\Constraint;

final class HasValidPeriod extends Constraint
{
    public $message = 'The start cannot be after the end of the period.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
