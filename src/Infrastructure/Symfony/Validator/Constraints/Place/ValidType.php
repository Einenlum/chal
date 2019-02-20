<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Validator\Constraints\Place;

use Symfony\Component\Validator\Constraint;

final class ValidType extends Constraint
{
    public $message = 'The type {{ value }} is not allowed. Valid types are: {{ valid_types }}.';
}
