<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Request\Subscriber;

use App\Infrastructure\Symfony\Request\Annotations\Extractor;
use App\Infrastructure\Symfony\Response\Failure\BadRequestResponse;
use App\Infrastructure\Symfony\Response\Failure\NotFoundResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * This subscriber runs after the DecodeJson subscriber.
 * If the Controller __invoke action has an @InjectDTO Annotation,
 * it will take the data from the request (the decoded json content)
 * and transform it into the asked DTO.
 *
 * The DTO is validated and if errors appear, the errors are serialized
 * and sent as response.
 * If everything is ok, the DTO is injected in the Request's attributes,
 * so that the controller can have it injected automatically as a
 * `$dto` argument.
 */
final class InjectDTOIfNeeded implements EventSubscriberInterface
{
    private $extractor;
    private $validator;
    private $serializer;

    public function __construct(
        Extractor $extractor,
        ValidatorInterface $validator,
        SerializerInterface $serializer
    ) {
        $this->extractor = $extractor;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function injectInRequest(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (null === $annotation = $this->extractor->extract($controller)) {
            return;
        }

        $dtoClass = $annotation->class;

        $request = $event->getRequest();
        $data = $request->attributes->get('data');
        foreach ($annotation->mapping as $attributeName => $mapToVar) {
            $value = $request->attributes->get($attributeName);
            if (null === $value) {
                $controller = function () use ($attributeName) {
                    return NotFoundResponse::withTitle(
                        sprintf('Attribute %s was not found', $attributeName)
                    );
                };
                $event->setController($controller);
            }

            $data[$mapToVar] = $value;
        }

        $dto = $this->serializer->denormalize($data, $dtoClass);
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            $badRequestResponse = BadRequestResponse::fromViolationList($errors);

            $event->setController(function () use ($badRequestResponse) {
                return $badRequestResponse;
            });
        }

        $request->attributes->set('dto', $dto);
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => ['injectInRequest']];
    }
}
