<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class IsDateTimeInterface extends Constraint
{
    public $message = 'The value must be a datetime.';
}
