<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Failure;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Doctrine\Common\Util\Inflector;

final class TypeBuilder
{
    /**
     * Transforms an HttpExceptionInterface class name into a message type.
     * Ex: Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * becomes "Not Found"
     */
    public function createType(\Exception $exception): string
    {
        if (!$exception instanceof HttpExceptionInterface) {
            return 'Internal Server Error';
        }

        $fqcn = get_class($exception);
        $name = substr($fqcn, strrpos($fqcn, '\\')+1);
        $name = Inflector::tableize($name);
        $name = str_replace('_', ' ', $name);
        $name = substr($name, 0, -strlen(' http exception'));
        $name = join(' ', array_map('ucfirst', explode(' ', $name)));

        return $name;
    }
}
