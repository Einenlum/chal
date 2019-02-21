<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Response\Subscriber;

use App\Infrastructure\Serializer\JsonSerializer;
use App\Infrastructure\Symfony\Response\Failure\CustomResponse;
use App\Infrastructure\Symfony\Response\Failure\TypeBuilder;
use App\Infrastructure\Symfony\Response\Http\JsonResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionSubscriber implements EventSubscriberInterface
{
    private $serializer;
    private $typeBuilder;
    private $debugActivated;

    public function __construct(JsonSerializer $serializer, TypeBuilder $typeBuilder, bool $debugActivated)
    {
        $this->serializer = $serializer;
        $this->typeBuilder = $typeBuilder;
        $this->debugActivated = $debugActivated;
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
            KernelEvents::EXCEPTION => ['serializeException'],
        ];
    }

    private function buildCustomResponse(\Exception $exception)
    {
        $type = $this->typeBuilder->createType($exception);
        $title = $exception instanceof HttpExceptionInterface
            ? $exception->getMessage()
            : $this->debugActivated ? $exception->getMessage() : ''
        ;

        $details = $this->debugActivated
            ? [$exception->getTraceAsString()]
            : []
        ;

        return CustomResponse::createWithTypeAndTitle($type, $title, $details);
    }

    private function getStatusCode(\Exception $exception): int
    {
        return $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : 500
        ;
    }
}
