<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request\Annotations;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
final class InjectDTO
{
    public $class;
}
