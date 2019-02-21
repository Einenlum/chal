<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Normalizer implements NormalizerInterface
{
    private $normalizer;

    private $factories = [];

    public function __construct(ObjectNormalizer $normalizer, iterable $factories)
    {
        $this->normalizer = $normalizer;
        $this->factories = [];
        foreach ($factories as $factory) {
            $this->factories[] = $factory;
        }
    }

    public function normalize($object, $format = null, array $context = [])
    {
        if (null !== $factory = $this->getFactoryForObject($object)) {
            $object = $factory->buildProxy($object);
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, $format = null)
    {
        return null !== $this->getFactoryForObject($data);
    }

    protected function getFactoryForObject($object)
    {
        foreach ($this->factories as $factory) {
            if (true === $factory->supportsObject($object)) {
                return $factory;
            }
        }
    }
}
