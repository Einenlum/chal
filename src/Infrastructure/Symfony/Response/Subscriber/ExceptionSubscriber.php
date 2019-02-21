<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use App\Infrastructure\Serializer\JsonSerializer;
use App\Infrastructure\Symfony\Response\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\Common\Util\Inflector;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use App\Infrastructure\Symfony\Response\Failure\CustomResponse;
use App\Infrastructure\Symfony\Response\Failure\TypeBuilder;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    private $serializer;
    private $typeBuilder;

    public function __construct(JsonSerializer $serializer, TypeBuilder $typeBuilder)
    {
        $this->serializer = $serializer;
        $this->typeBuilder = $typeBuilder;
    }

    public function serializeException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $response = new JsonResponse(
            $this->serializer->serialize($this->buildCustomResponse($exception)),
            $this->getStatusCode($exception)
        );

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['serializeException']
        ];
    }

    private function buildCustomResponse(\Exception $exception)
    {
        $type = $this->typeBuilder->createType($exception);
        $title = $exception instanceof HttpExceptionInterface
            ? $exception->getMessage()
            : ''
        ;

        return CustomResponse::createWithTypeAndTitle($type, $title);
    }

    private function getStatusCode(\Exception $exception): int
    {
        return $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500
        ;
    }
}
