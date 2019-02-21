<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request\Annotations;

use Doctrine\Common\Annotations\Reader;

/**
 * This class extracts the InjectDTO annotation on the __invoke method of
 * the controller if it exists, and returns the DTO class the controller
 * will receive as argument.
 */
class Extractor
{
    private $reader;

    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function extract(object $controller): ?InjectDTO
    {
        $refClass = new \ReflectionClass(get_class($controller));
        $refMethod = $refClass->getMethod('__invoke');

        $dtoAnnotation = $this->reader->getMethodAnnotation($refMethod, InjectDTO::class);

        if (null === $dtoAnnotation) {
            return null;
        }

        return $dtoAnnotation;
    }
}
