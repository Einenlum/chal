<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request\Annotations;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
final class InjectDTO
{
    /** @Required */
    public $class;

    /** @param array */
    public $mapping = [];
}
