<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Geolocation\Position;

use Symfony\Component\Validator\Constraint;

final class ValidLongitude extends Constraint
{
    public $message = 'A valid longitude is between {{ min_value }} and {{ max_value }}.';
}
